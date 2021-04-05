<?php
   include('verifica.php');
   header('Content-Type: text/html; charset=utf-8');
?>

<!doctype html>
<html>
<?php include_once('includes/head_padrao.php'); ?>

<body>
	<div id="principal">
    	<head>
         <?php include('menu-interno.php'); ?>
         
         <ol class="breadcrumb efeito-well mg-bottom-10">
            <li><?php echo $_SESSION['usu_nome']; ?>&nbsp;&nbsp;<a href="logout.php">(Sair)</a></li>
            <li><a href="principal.php">In&iacute;cio</a></li>
            <li><strong>Alterar Senha</strong></li>
         </ol>
      </head>

      <?php include_once('includes/flashmsg.php');?>

       <div id="alterar_senha">
          <br>
          <form class="navbar-form" action="gravar_senha.php" method="POST" name="form_senha" id="form_senha">

             <div class="input-group">
                <label for="senha_atual" class="sr-only">Senha atual: </label>
                <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                <input type="password" id="senha_atual" name="senha_atual" placeholder="Senha Atual"
                 required autofocus class="form-control">
             </div>

             <br><br>
             
             <div class="input-group">
                <label for="senha" class="sr-only">Senha nova: </label>
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" id="senha" name="senha" required
                 placeholder="Nova Senha" class="form-control">
             </div>
             
             <br><br>

             <div class="input-group">
                <label for="senha2" class="sr-only">Repita a senha: </label>
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" id="senha2" name="senha2" required
                 placeholder="Digite novamente" class="form-control">
             </div>
             <br><br>

             <button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Gravar</button>
          </form>
       </div>

       <br>

      <?php include ('includes/rodape.php'); ?>

    </div>
    
    <?php include ('bibliotecasjs.php'); ?>
</body>
</html>