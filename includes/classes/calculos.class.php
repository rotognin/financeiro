<?php
   final class Calculos
   {
      // Classe que n�o poder� ser instanciada
      private function __construct(){}

      public static function saldoAtual($usuario, $local, $conexao)
      {
         // Essa fun��o ir� retornar o saldo atual do local que for passado

         // Somar os cr�ditos
         $comando = 'SELECT SUM(mov_valor_credito) AS "Credito" FROM movimentos_tb ' .
                    'WHERE mov_usu_id = ' . $usuario .
                    ' AND mov_local_credito = ' . $local;

         $resultado = $conexao->query($comando);
         $linha = $resultado->fetch(PDO::FETCH_BOTH);
         $credito = (float)$linha[0];

         // Somar os d�bitos
         $comando = 'SELECT SUM(mov_valor_debito) AS "Debito" FROM movimentos_tb ' .
                    'WHERE mov_usu_id = ' . $usuario .
                    ' AND mov_local_debito = ' . $local;

         $resultado = $conexao->query($comando);
         $linha = $resultado->fetch(PDO::FETCH_BOTH);
         $debito = (float)$linha[0];

         return ($credito - $debito);
      }

      public static function locaisBanco($usuario, $conexao, $ativo = 'X')
      {
         // Essa fun��o ir� acumular em um array todos os locais que forem
         // banco para aquele usu�rio passado
         $comando = 'SELECT loc_id FROM locais_tb WHERE loc_usu_id = ' . $usuario .
                    ' AND loc_banco = "S"';

         // Por padr�o, ir�o ser filtrados todos os locais, sejam ativos ou n�o
         if ($ativo != 'X') {
            $comando .= ' AND loc_ativo = "' . $ativo . '"';
         }

         $resultado = $conexao->query($comando);

         $locais = array();

         while ($linha = $resultado->fetch(PDO::FETCH_BOTH)) {
            $locais[] = $linha[0];
         }

         return $locais;
      }
   }
?>