<?php
   include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');
   require_once('includes/funcoes/saldoatual.php');

    $tipos = array(
      'Compra' => 'compra',
      'Venda' => 'venda',
      'Transferência' => 'transferencia',
      'Entrada' => 'entrada',
      'Saída' => 'saida');

   $mov_usu_id = (int)$_SESSION['usu_logado'];
   $mov_end_usu = (int)$_SESSION['end_usu_logado'];
   $mov_descricao = addslashes($_POST['descricao']);
   $mov_valor = $_POST['valor'];
   $tipo = (string)$_POST['tipo'];

   $mov_valor_cre = (float)0.00;
   $mov_valor_deb = (float)0.00;
   $mov_local_cre = (int)0;
   $mov_local_deb = (int)0;

   switch ($tipos[$tipo]) {
      case 'compra': {
         $mov_valor_cre = $mov_valor;
         $mov_local_cre = (int)$_POST['local1'];
         $mov_valor_deb = $mov_valor;
         $mov_local_deb = (int)$_POST['local2'];
         break;
      }
      case 'venda': {
         $mov_valor_cre = $mov_valor;
         $mov_local_cre = (int)$_POST['local1'];
         break;
      }
      case 'transferencia': {
         $mov_valor_cre = $mov_valor;
         $mov_local_cre = (int)$_POST['local1'];
         $mov_valor_deb = $mov_valor;
         $mov_local_deb = (int)$_POST['local2'];
         break;
      }
      case 'entrada': {
         $mov_valor_cre = $mov_valor;
         $mov_local_cre = (int)$_POST['local1'];
         break;
      }
      case 'saida': {
         $mov_valor_deb = $mov_valor;
         $mov_local_deb = (int)$_POST['local1'];
         break;
      }
   }

   // Verificar o tipo de movimentação. Se for transferência, os locais não
   // podem ser iguais
   if ($tipos[$tipo] == 'transferencia') {
      if ($mov_local_cre == $mov_local_deb) {
         $_SESSION['msg_erro'] = 'Ao realizar uma transferência, os locais ' .
                                 'devem ser diferentes.';
         header ('Location: movimentacao.php?tipo=transferencia');
         exit;
      }
   }

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: movimentacao.php?tipo=' . $tipos[$tipo]);
      exit;
   }

   // Checar se o local de débito possui saldo para realizar a movimentação
   if ($mov_local_deb > 0) {
      $saldo_atual = saldoAtual($_SESSION['usu_logado'], $mov_local_deb, $conn);

      if ($saldo_atual < $mov_valor_deb) {
         $_SESSION['msg_erro'] = 'O local de débito selecionado não possui valor necessário ' .
                                 'para realizar a movimentação.';
         header ('Location: movimentacao.php?tipo=' . $tipos[$tipo]);
         exit;
      }
   }

   $mov_valor_cre_f = str_replace(',','', $mov_valor_cre);
   $mov_valor_deb_f = str_replace(',','', $mov_valor_deb);

   $comando = 'INSERT INTO movimentos_tb (mov_usu_id, mov_end_usu, mov_valor_credito, ' .
              'mov_valor_debito, mov_local_credito, mov_local_debito, mov_descricao, ' .
              'mov_tipo) ' .
              ' VALUES (' . $mov_usu_id . ', ' .
                            $mov_end_usu . ', ' .
                            $mov_valor_cre_f . ', ' .
                            $mov_valor_deb_f . ', ' .
                            $mov_local_cre . ', ' .
                            $mov_local_deb . ', "' .
                            $mov_descricao . '", "' .
                            $tipos[$tipo] . '")';

   echo $comando;

   $resultado = $conn->query($comando);
   if ($resultado->rowCount() == 0) {
      $_SESSION['msg_erro'] = 'Não foi possível gravar a movimentação.';
   }
   else {
      $_SESSION['msg_erro'] = 'Movimentação gravada com sucesso.';
   }

   header ('Location: principal.php');
   exit;
?>