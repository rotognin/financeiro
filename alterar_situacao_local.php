<?php
   include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');
   
   // Pegar as variáveis por GET
   $id = filter_input(INPUT_GET,"id_local",FILTER_VALIDATE_INT);
   $situacao = (string)$_GET['situacao'];
   
   if (!$conn = Conexao::abrir()) {
      return;
   }
   
   $comando = 'UPDATE locais_tb SET loc_ativo = "' . $situacao . 
              '" WHERE loc_id = ' . $id;
   $resultado = $conn->query($comando);
   
   if ($resultado->rowCount() != 1) {
      $_SESSION['msg_erro'] = 'Não foi possível alterar o cadastro.';
   }
?>