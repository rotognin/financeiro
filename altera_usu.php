<?php
   include('verifica.php');
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $usu_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
   $acao = '';

   switch ($_GET['realizar']) {
      case 'bloquear':    {$acao = 'B'; break; }
      case 'inativar':    {$acao = 'I'; break; }
      case 'liberar':     {$acao = 'S'; break; }
      case 'ativar':      {$acao = 'S'; break; }
      case 'desbloquear': {$acao = 'S'; break; }
   }

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: lista_usuarios.php');
   }

   $comando = "UPDATE usuarios_tb SET usu_flag = '$acao' WHERE usu_id = $usu_id";
   $conn->exec($comando);
?>