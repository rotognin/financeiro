<?php
session_start();

if(!isset($_SESSION['usu_logado']) || $_SESSION['usu_logado'] == ''){
   header("Location: 'acesso.php'");
}
?>