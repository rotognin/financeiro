<?php
   include('verifica.php');
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: lista_local.php');
      exit;
   }

   $senha_ant = sha1($_POST['senha_atual']);

   if ($_POST['senha'] != $_POST['senha2']) {
      $_SESSION['msg_erro'] = 'As senhas devem ser iguais.';
      header ('Location: alterar_senha.php');
      exit;
   }

   $senha_nova = sha1($_POST['senha']);

   $comando = 'SELECT usu_senha FROM usuarios_tb WHERE usu_id = ' . $_SESSION['usu_logado'];
   $resultado = $conn->query($comando);
   $lista = $resultado->fetch(PDO::FETCH_ASSOC);
   $senha_atual = $lista['usu_senha'];

   if ($senha_ant != $senha_atual) {
      $_SESSION['msg_erro'] = 'A senha atual é diferente da senha cadastrada.';
      header ('Location: alterar_senha.php');
      exit;
   }

   $comando = 'UPDATE usuarios_tb SET usu_senha = "' . $senha_nova .
              '" WHERE usu_id = ' . $_SESSION['usu_logado'];

   $resultado = $conn->query($comando);
   if ($resultado->rowCount() == 0) {
      $_SESSION['msg_erro'] = 'Não foi possível alterar a sua senha. Tente novamente mais tarde.';
      header ('Location: alterar_senha.php');
      exit;
   }

   $_SESSION['msg_erro'] = 'Senha alterada com sucesso.';
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Controle Financeiro</title>

    <link href="css/estilo.css" type="text/css" rel="stylesheet">
</head>

<body>
	<div id="principal">
    	<head>
        	<div id="cabecalho"><h1>Controle Financeiro Pessoal - <?php echo $_SESSION['usu_nome']; ?></h1></div>
    		<hr>
         <div id="navegacao"> <?php echo $_SESSION['usu_nome']; ?> <a href="logout.php">(Sair)</a> - <a href="principal.php">In&iacute;cio</a> - Alterar Senha</div>
         <hr>
      </head>

      <hr><br>

      <?php include_once('includes/flashmsg.php');?>

      <br><br>

      <p><a href="principal.php">Voltar</a></p>
   </div>
</body>
</html>