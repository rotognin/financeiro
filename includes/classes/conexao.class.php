<?php
   // Classe stática de conexão
   require_once('config.php');
   
   final class Conexao
   {
      // Método privado para não ser instanciado
      private function __construct(){}
      
      public static function abrir()
      {
         $conn = new PDO($db_drive, DB_USER, DB_PASS);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $conn->exec('SET NAMES utf8');
         
         // retorna o objeto instanciado
         return $conn;
      }
   }
?>