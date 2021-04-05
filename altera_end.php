<?php
   include('verifica.php');
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $end_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
   $acao = $_GET['acao'];
   $atual = ($_GET['valor'] == "SIM") ? "N" : "S" ;

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: lista_endereco.php');
      exit;
   }

   $comando = 'UPDATE enderecos_tb SET ' . $acao . ' = "' . $atual .
              '" WHERE end_id = ' . $end_id;

   $resultado = $conn->query($comando);

   if ($resultado->rowCount() == 0) {
      echo 'Não foi possível atualizar o endereço.';
   }
   else {
      echo $comando;
   }
?>