<?php
   session_start();

   $loc_usu_id = $_SESSION['usu_logado'];
   $loc_end_usu = $_SESSION['end_usu_logado'];
   $loc_descricao = addslashes($_POST['descricao']);
   $loc_observacao = addslashes($_POST['observacao']);
   $loc_ativo = 'S';
   $loc_banco = ($_POST['banco'] == 'S') ? 'S' : 'N' ;

   // Cadastro do novo local no banco - usar PDO para conexão ao banco
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: novo_local.php');
      exit;
   }

   // Comando em SQL para inserir no banco o novo Local
   $comando = 'INSERT INTO locais_tb (loc_usu_id, loc_end_usu, loc_descricao, loc_observacao, loc_ativo, loc_banco) ' .
              'VALUES (' . $loc_usu_id . ', ' .
                           $loc_end_usu . ', "' .
                           $loc_descricao . '", "' .
                           $loc_observacao . '", "S", "' . 
                           $loc_banco . '")';

   echo $comando;
                           
   $resultado = $conn->query($comando);
   if ($resultado->rowCount() == 0)
   {
      $_SESSION['msg_erro'] = 'Não foi possível gravar o local.';
      header ('Location: novo_local.php');
      exit;
   }
   else
   {
      header ('Location: lista_local.php');
      exit;
   }
?>