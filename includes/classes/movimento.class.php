<?php
   /* Métodos da classe
   __construct() = Atribui os dados iniciais da tabela de movimentação financeira
   conectar() = Faz a conexão com o Banco de Dados utilizando DI
   lerLocalDebito() = Lê a tabela de débito e preenche o nome da tabela-banco
   lerSaldoAtual() = Lê o saldo atual da tabela-banco para a movimentação
   inserirMovimento() = Insere a movimentação na tabela
   lerHistorico() = Lê a tabela de histórico e retorna "D" ou "C"
   movimentoBanco() = Credita ou Debita o valor para o Saldo Atual
   gravarBanco() = Grava o movimento no Banco (Tabela auxiliar Local Tipo Ban)
   */

   // Classe que terão as funções relativas às movimentações
   class Movimento
   {
      private $local_despesa; // Local onde o dinheiro será "aplicado" (padaria, lanchonete, etc...)
      private $local_debito;  // Local tipo Banco de onde o dinheiro sairá
      private $historico;     // Histórico indicando o tipo de movimentação (conforme o uso)
      private $valor;         // Valor do movimento
      private $observacao;    // Observação adicional

      private $abreviacao;    // nome da tabela Banco para Débito
      private $saldo_atual;   // saldo atual do banco local débito

      private $conexao;       // Guarda a conexão com o banco

      function __construct($local_despesa, $local_debito, $historico, $valor, $observacao = "")
      {
         // Montar os atributos
         $this->local_despesa = $local_despesa;
         $this->local_debito = $local_debito;
         $this->historico = $historico;
         $this->valor = $valor;
         $this->observacao = $observacao;
      }

      function conectar()
      {
         // Pegar a conexão com o banco
         $volta_erro = 'erro.php';
         require_once('includes/conexao/conexao_pdo.php');
         $this->conexao = $conn;
      }

      // Ler a tabela de local para pegar o nome da tabela de movimento para débito
      function lerLocalDebito()
      {
         $comando = "SELECT loc_abreviacao FROM local_tb WHERE loc_id = '$this->local_debito'";
         $result = $this->conexao->query($comando);
         $this->abreviacao = $result->fetchColumn();
      }

      function lerSaldoAtual()
      {
         $comando = 'SELECT ' .
                    $this->abreviacao . '_saldo FROM ' .
                    $this->abreviacao . '_tb ORDER BY ' .
                    $this->abreviacao . '_id DESC';

         $result = $this->conexao->query($comando);
         $this->saldo_atual = $result->fetchColumn();
      }

      // Insere um movimento na tabela de movimentação
      function inserirMovimento()
      {
         $comando = 'INSERT INTO movimento_tb (mov_local_despesa, mov_local_debito, mov_historico, mov_valor, mov_observacao, mov_data, mov_hora) VALUES(' .
                    $this->local_despesa . ', ' .
                    $this->local_debito . ', ' .
                    $this->historico . ', ' .
                    $this->valor . ', "' .
                    $this->observacao . '", ' .
                    'CURRENT_DATE(), ' .
                    'CURRENT_TIME())';

         $this->conexao->exec($comando);
      }

      function movimentoBanco()
      {
         // Ler o cadastro do histórico para saber qual o tipo de
         // movimento: Crédito ou Débito
         if ($this->lerHistorico() == 'D')
         {
            $saldo_novo = $this->saldo_atual - $this->valor;
         }
         else
         {
            $saldo_novo = $this->saldo_atual + $this->valor;
         }
      }

      private function lerHistorico()
      {
         // Ler a tabela de hitórico e retornar se é "D" ou "C"
         $comando = 'SELECT his_tipo FROM historico_tb WHERE his_id = ' . $this->historico;
         $result = $this->comexao->query($comando);
         return $result->fetchColumn();
      }

      function gravarBanco()
      {
         // Gravar o movimento naquele banco com o saldo novo
         $comando = 'INSERT INTO ' . $this->abreviacao . '_tb (' .
                    $this->abreviacao . '_valor, ' .
                    $this->abreviacao . '_historico, ' .
                    $this->abreviacao . '_data, ' .
                    $this->abreviacao . '_hora, ' .
                    $this->abreviacao . '_saldo) VALUES (' .
                    $this->valor . ', ' .
                    $this->historico . ', ' .
                    'CURRENT_DATE(), ' .
                    'CURRENT_TIME(), ' .
                    $saldo_novo . ')';

         $this->conexao->exec($comando);
      }
   }
?>