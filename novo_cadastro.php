<?php
   session_start();

   if (!isset($_SESSION['msg_erro']) || $_SESSION['msg_erro'] == '')
   {
      $_SESSION['usu_nome'] = '';
      $_SESSION['usu_login'] = '';
      $_SESSION['usu_email'] = '';
      $_SESSION['msg_erro'] = '';
   }

?>

<!doctype html>
<html>
<?php include_once('includes/head_padrao.php'); ?>

<body>
	<div id="principal"  class="container-fluid">
    	<?php include ('includes/cabecalho.php'); ?>
      <br>
      <?php include('includes/flashmsg.php'); ?>

         <div id="novo_cadastro">
            <form class="navbar-form" action="incluir_usuario.php" method="POST" name="form_novo" id="form_novo">

                  <div class="input-group mg-bottom-10">
                     <label class="sr-only" for="nome">Nome: </label>
                     <span class="input-group-addon" id="basic-addon2">Nome: </span>
                     <input type="text" class="form-control" id="nome" name="nome"
                      required autofocus value="<?php echo $_SESSION['usu_nome']; ?>">
                  </div>
                  <br>
                  <div class="input-group mg-bottom-10">
                     <label class="sr-only" for="login">Login: </label>
                     <span class="input-group-addon" id="basic-addon2">Login: </span>
                     <input type="text" class="form-control" id="login" name="login"
                      required value="<?php echo $_SESSION['usu_login']; ?>">
                  </div>
                  <br>
                  <div class="input-group mg-bottom-10">
                     <label class="sr-only" for="senha">Senha: </label>
                     <span class="input-group-addon" id="basic-addon2">Senha: </span>
                     <input type="password" class="form-control" id="senha" name="senha" required>
                  </div>
                  <br>
                  <div class="input-group mg-bottom-10">
                     <label class="sr-only" for="senha2">Repita a senha: </label>
                     <span class="input-group-addon" id="basic-addon2">Repita a senha: </span>
                     <input type="password" class="form-control" id="senha2" name="senha2" required>
                  </div>
                  <br>
                  <div class="input-group mg-bottom-10">
                     <label class="sr-only" for="email">E-mail: </label>
                     <span class="input-group-addon" id="basic-addon2">E-mail: </span>
                     <input type="email" class="form-control" id="email" name="email"
                      required value="<?php echo $_SESSION['usu_email']; ?>">
                  </div>

                <br>

               <button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Gravar</button>
            </form>

         </div>

        <?php include ('includes/rodape.php'); ?>

    </div>

</body>
</html>