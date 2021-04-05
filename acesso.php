<?php
   session_start();

   if (isset($_SESSION['usuario']) && $_SESSION['usuario'] != '')
   {
      header ('Location: principal.php');
   }

?>

<!doctype html>
<html>
<?php include_once('includes/head_padrao.php'); ?>

<body>
	<div id="principal" class="container-fluid">
    	<?php include ('includes/cabecalho.php'); ?>

      <br>
         <div id="acesso">
            <div id="retorno">
               <?php include_once('includes/flashmsg.php'); ?>
            </div>

            <form class="navbar-form" action="verifica_login.php" method="POST" name="form_login" id="form_login">
               <p>
                  <div class="input-group">
                     <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                     <input type="text" class="form-control" id="login" name="login" required autofocus placeholder="login">
                  </div>
               </p>

                <p>
                   <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key"></i></span>
                      <input type="password" class="form-control" id="senha" name="senha" required placeholder="senha">
                   </div>
                </p>

                <br>
               <button type="submit" class="btn btn-default"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Acessar</button>
            </form>
            <br>
            
            <br>
            <div class="criar">Se desejar utilizar o controle financeiro, <button type="button" id="btn-cadastro" class="btn btn-default"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;clique aqui </button> para se cadastrar!</div>
         </div>

        <?php include ('includes/rodape.php'); ?>

    </div>
    
    <script charset="utf-8" src="jquery/jquery-2.1.3.min.js"></script>
    <script>
      $(document).ready(function(){
         $("#btn-cadastro").click(function(e){
            e.preventDefault();
            window.location.href = "novo_cadastro.php";
         });
      });
    </script>
</body>
</html>