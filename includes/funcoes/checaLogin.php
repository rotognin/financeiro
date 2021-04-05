<?php
   session_start();

   header('Content-Type: text/html; charset=utf-8');

   $login = mysql_real_escape_string(strip_tags($_GET['login']));
   $senha = mysql_real_escape_string(strip_tags($_GET['senha']));

   $_SESSION['erro'] = '';

   require_once('../conexao/conexao.class.php');

   if ($_SESSION['erro'] == '')
   {
      $query = "SELECT * FROM usuarios_tb WHERE usu_login = '$login'";
      $result = $conn->query($query);

      if ($result->rowCount() > 0)
      {
         $linha = $result->fetch(PDO::FETCH_ASSOC);

         // Comparar o login
         if ($linha['usu_login'] == $login)
         {
            // Comparar a senha
            $senha_banco = sha1($senha);

            if ($linha['usu_senha'] == $senha_banco)
            {
               // Login = OK
               $_SESSION['usuario'] = $linha['usu_nome'];
               $_SESSION['login'] = $linha['usu_login'];
               $resposta = 'ok';
            }
            else
            {
               $resposta = 'Usuário ou senha inválidos.';
            }
         }
         else
         {
            $resposta = 'Usuário ou senha inválidos.';
         }
      }
      else
      {
         $resposta = 'Usuário ou senha inválidos.';
      }
   }
   else
   {
      $resposta = $_SESSION['erro'];
   }

   echo $resposta;

?>
