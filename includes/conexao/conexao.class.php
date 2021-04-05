<?php
   // Classe estática de conexão
   
   final class Conexao
   {
      // Método privado para não ser instanciado
      private function __construct(){}
      
      public static function abrir()
      {
         require_once('config.php');

         try
         {
            $conn = new PDO($db_drive, DB_USER, DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         }
         catch(PDOException $erro)
         {
            $msg_erro = $erro->getMessage();
            $_SESSION['msg_erro'] = 'Erro ao acessar o banco de dados: ' . $msg_erro;
            return false;
         }

         $conn->exec('SET NAMES utf8');
         // retorna o objeto de conexão
         return $conn;
      }
   }
?>