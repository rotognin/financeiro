<?php
   include('verifica.php');
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: lista_local.php');
      exit;
   }

   $loc_id = $_POST['loc_id'];
   $loc_descricao = strip_tags(addslashes($_POST['descricao']));
   $loc_observacao = strip_tags(addslashes($_POST['observacao']));
   $loc_universal = $_POST['universal'];

   $comando = 'UPDATE locais_tb SET loc_descricao = "' . $loc_descricao . '", ' .
                                   'loc_observacao = "' . $loc_observacao . '" ' .
                                   'loc_universal = "' . $loc_universal . '" ' .
                                   'WHERE loc_id = "' . $loc_id . '"';

   $resultado = $conn->query($comando);

   if ($resultado->rowCount() > 0) {
      header ('Location: lista_local.php');
      exit;
   }
   else {
      $_SESSION['msg_erro'] = 'Não foi possível atualizar. <br>' . $comando;
      header ('Location: lista_local.php');
      exit;
   }
?>