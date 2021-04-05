<?php
   include('verifica.php');
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      echo $_SESSION['msg_erro'];
      exit;
   }

   $comando = 'SELECT * FROM usuarios_tb ORDER BY usu_id DESC';
   $resultado = $conn->query($comando);

?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Controle Financeiro - Usuários</title>
   <link href="css/estilo.css" type="text/css" rel="stylesheet">
</head>

<body>
	<div id="principal">
    	<head>
        	<div id="cabecalho"><h1>Controle Financeiro Pessoal - <?php echo $_SESSION['usu_nome']; ?></h1></div>
    		<hr>
            <div id="navegacao"> <?php echo $_SESSION['usu_nome']; ?> <a href="logout.php">(Sair)</a></div>
            <hr>
        </head>

        <section id="usu_conteudo">
           <div id="cabecalho_usuarios">
              <div id="cab_usu_id">ID</div>
              <div id="cab_usu_nome">Nome</div>
              <div id="cab_usu_login">Login</div>
              <div id="cab_usu_email">E-mail</div>
              <div id="cab_usu_situacao">Situação</div>
              <div id="cab_usu_acoes">Ações</div>
           </div>

           <div id="clear_float"></div>
           <hr>

           <div id="dados_usuarios">

           <?php
              if ($resultado->rowCount() > 0)
              {
                 // Loop para listar todos os registros
                 foreach ($resultado as $linha)
                 {
           ?>
                    <div id="dad_usu_id"><?php echo $linha['usu_id']; ?></div>
                    <div id="dad_usu_nome"><?php echo $linha['usu_nome']; ?></div>
                    <div id="dad_usu_login"><?php echo $linha['usu_login']; ?></div>
                    <div id="dad_usu_email"><?php echo $linha['usu_email']; ?></div>

                       <?php
                          switch ($linha['usu_flag']) {
                             case 'S': {
                       ?>
                                <div id="dad_usu_situacao">Liberado</div>
                                <div id="dad_usu_acoes">
                                   <input type="button" value="Bloquear" 
                                      onclick="executar('bloquear','<?php echo $linha['usu_id']; ?>');">
                                   <input type="button" value="Inativar"
                                      onclick="executar('inativar','<?php echo $linha['usu_id']; ?>');">
                                </div>
                       <?php
                                break;
                             }
                             case 'N': {
                       ?>
                                <div id="dad_usu_situacao">Não liberado</div>
                                <div id="dad_usu_acoes">
                                   <input type="button" value="Liberar"
                                      onclick="executar('liberar','<?php echo $linha['usu_id']; ?>');">
                                </div>
                       <?php
                                break;
                             }
                             case 'I': {
                       ?>
                                <div id="dad_usu_situacao">Inativo</div>
                                <div id="dad_usu_acoes">
                                   <input type="button" value="Ativar"
                                      onclick="executar('ativar','<?php echo $linha['usu_id']; ?>');">
                                </div>
                       <?php
                                break;
                             }
                             case 'B': {
                       ?>
                                <div id="dad_usu_situacao">Bloqueado</div>
                                
                                <div id="dad_usu_acoes">
                                   <input type="button" value="Desbloquear"
                                      onclick="executar('desbloquear','<?php echo $linha['usu_id']; ?>');">
                                </div>
                       <?php
                                break;
                             }
                             case 'A': {
                       ?>
                                <div id="dad_usu_situacao">-</div>
                                <div id="dad_usu_acoes">-</div>
                       <?php
                                break;
                             }
                          }
                       ?>

                    <div id="clear_float"></div>
           <?php
                 }
              }
           ?>

           </div>

           <div id="clear_float"></div>

        </section>

        <?php include ('includes/rodape.php'); ?>
    </div>
    
    <script type="text/javascript" src="jquery/jquery-2.1.3.min.js"></script>
    <script type="text/javascript">
       function executar(acao, id_usuario)
       {
          var acaoExecutar = acao;
          var idAtualizar = id_usuario;
       
          $.get('altera_usu.php',{realizar:acaoExecutar,id:idAtualizar}, function() {
             window.location.href = 'lista_usuarios.php';
          });
       }
    </script>
</body>
</html>