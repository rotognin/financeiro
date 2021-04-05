<?php
   require_once('config.php');

   try
   {
      $conn = new PDO($db_drive,DB_USER,DB_PASS);
	   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOException $erro)
   {
		$msg_erro = $erro->getMessage();
		$_SESSION['erro'] = 'Erro ao acessar o banco de dados: ' . $msg_erro;
   }

   $conn->exec('SET NAMES utf8');
?>