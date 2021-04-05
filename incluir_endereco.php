<?php
   include_once('verifica.php');
   header('Content-Type: text/html; charset=utf-8');

   $_SESSION['msg_erro'] = '';
   require_once('includes/conexao/conexao.class.php');

   function protegerVars($variavel)
   {
      return strip_tags(addslashes($variavel));
   }

   // Proteger todas as variáveis vindas do formulário por POST
   foreach ($_POST as $valor) {
      if (!empty($valor)) {
         protegerVars($valor);
      }
   }

   $conn = Conexao::abrir();

   // Montar o Insert
   $comando = 'INSERT INTO enderecos_tb (end_usu_id, end_descricao, end_endereco, ' .
              'end_numero, end_complemento, end_bairro, end_cidade, end_estado, ' .
              'end_cep, end_pais, end_padrao, end_ativo) VALUES (' .
              $_SESSION['usu_logado'] . ', "' .
              $_POST['end_descricao'] . '", "' .
              $_POST['end_endereco'] . '", "' .
              $_POST['end_numero'] . '", "' .
              $_POST['end_complemento'] . '", "' .
              $_POST['end_bairro'] . '", "' .
              $_POST['end_cidade'] . '", "' .
              $_POST['end_estado'] . '", "' .
              $_POST['end_cep'] . '", "' .
              $_POST['end_pais'] . '", "S", "S")';
   $resultado = $conn->query($comando);

   if ($resultado->rowCount() == 0) {
      $_SESSION['msg_erro'] = 'Erro ao cadastrar endereço no banco';
      header ('Location: novo_endereco.php');
      exit;
   }

   if (isset($_SESSION['pri_endereco']) && $_SESSION['pri_endereco'] == 'S') {
      // colocar o endereço inserido na session
      $_SESSION['end_usu_logado'] = $conn->lastInsertId();
      $_SESSION['pri_endereco'] = 'N';
      header ('Location: principal.php');
      exit;
   }

   // Se chegou aqui, inseriu o endereço no banco
   header ('Location: lista_endereco.php');
?>