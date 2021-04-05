<?php
   include_once('verifica.php');
   header('Content-Type: text/html; charset=utf-8');

   // Pegar a variável de sessão "alvo" para saber o seguinte:
   // "adicionar" - Está adicionando um novo endereço
   // "editar" - Está querendo alterar um endereço já cadastrado
   // "novo" - Está adicionando um endereço já estando logado

   if (!isset($_SESSION['alvo'])) {
      $_SESSION['alvo'] = 'novo';
   }

   $carrega = false;

   if (isset($_GET['altera']) && $_GET['altera'] > 0) {
      $_SESSION['alvo'] = 'altera';
      $alvo = 'alterar_endereco.php';

      require_once('includes/conexao/conexao_pdo.php');
      $comando = 'SELECT * FROM enderecos_tb WHERE end_usu_id = ' . $_SESSION['usu_logado'] .
                 ' AND end_id = ' . $_GET['altera'] ;

      $resultado = $conn->query($comando);

      if ($resultado->rowCount() == 0) {
         header ('Location: lista_endereco.php');
         exit;
      }

      $lista = $resultado->fetch(PDO::FETCH_ASSOC);
      $carrega = true;
   }
   else {
      $alvo = 'incluir_endereco.php' ;
   }
?>

<!doctype html>
<html>
<?php include_once('includes/head_padrao.php'); ?>

<body>
	<div id="principal" class="container-fluid">
      <head>
      	<?php include('menu-interno.php'); ?>

         <ol class="breadcrumb efeito-well mg_bottom-10">
            <li><?php echo $_SESSION['usu_nome']; ?>&nbsp;&nbsp;<a href="logout.php">(Sair)</a></li>

            <?php
               if ($_SESSION['alvo'] == 'adicionar') {
                  echo '<li><strong>Novo Endereço</strong></li>';
               }
               elseif ($_SESSION['alvo'] == 'novo') {
                  echo '<li><a href="principal.php">In&iacute;cio</a></li> ' .
                       '<li><a href="lista_endereco.php">Listagem de Endereços</a></li> ' .
                       '<li><strong>Novo Endereço</strong></li>';
               }
               else {
                  echo '<li><a href="principal.php">In&iacute;cio</a></li> ' .
                       '<li><a href="lista_endereco.php">Listagem de Endereços</a></li> ' .
                       '<li><strong>Alterar Endereço</strong></li>';
               }
            ?>
         </ol>
      </head>

      <div id="endereco">
         <!--div class="efeito-well altura-maior">Os campos em vermelho são obrigatórios</div-->

         <?php include_once('includes/flashmsg.php'); ?>
         <br>
         <form class="navbar-form" action="<?php echo $alvo; ?>" method="POST" name="form_endereco" id="form_endereco">

            <div class="row">
               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_descricao" class="sr-only">Descrição: </label>
                     <span class="input-group-addon"><i class="fa fa-home cor-vermelha"></i></span>
                     <input class="form-control" type="text" id="end_descricao" name="end_descricao" required autofocus
                      placeholder="Descrição"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_descricao'] . '"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_endereco" class="sr-only">Endereço: </label>
                     <span class="input-group-addon"><i class="fa fa-building"></i></span>
                     <input class="form-control" type="text" id="end_endereco" name="end_endereco"
                      placeholder="Endereço"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_endereco'] . '"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_numero" class="sr-only">Número: </label>
                     <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
                     <input class="form-control" type="text" id="end_numero" name="end_numero" placeholder="Número"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_numero'] . '"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_complemento" class="sr-only">Complemento: </label>
                     <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                     <input class="form-control" type="text" id="end_complemento" name="end_complemento"
                      placeholder="Complemento"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_complemento'] . '"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_bairro" class="sr-only">Bairro: </label>
                     <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                     <input class="form-control" type="text" id="end_bairro" name="end_bairro"
                      placeholder="Bairro"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_bairro'] . '"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_cidade" class="sr-only">Cidade: </label>
                     <span class="input-group-addon"><i class="fa fa-map-marker cor-vermelha"></i></span>
                     <input class="form-control" type="text" id="end_cidade" name="end_cidade" required
                      placeholder="Cidade"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_cidade'] . '"';
                     }
                     else {
                        echo 'placeholder="Informar"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_estado" class="sr-only">Estado: </label>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-flag cor-vermelha"></span></span>
                     <input class="form-control" type="text" id="end_estado" name="end_estado" required
                      placeholder="Estado"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_estado'] . '"';
                     }
                     else {
                        echo 'placeholder="SP"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_cep" class="sr-only">CEP: </label>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
                     <input class="form-control" type="text" id="end_cep" name="end_cep"
                      placeholder="CEP"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_cep'] . '"';
                     } ?>>
                  </div>
               </div>

               <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                  <div class="input-group mg-bottom-10">
                     <label for="end_pais" class="sr-only">País: </label>
                     <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                     <input class="form-control" type="text" id="end_pais" name="end_pais"
                      placeholder="País"
                     <?php if ($carrega) {
                        echo 'value="' . $lista['end_pais'] . '"';
                     } ?>>
                  </div>
               </div>
            </div>
            <br>
            <div class="row">
               <button type="submit" class="alinha-centro">
                  <?php if ($carrega) {
                     echo 'Atualizar';
                  }
                  else {
                     echo 'Gravar';
                  } ?>
               </button>
            </div><!-- row -->

            <input type="hidden" name="end_usu_id" value="<?php echo $_SESSION['usu_logado']; ?>">
            <?php
               if ($carrega) {
                  echo '<input type="hidden" name="end_id" value="' . $lista['end_id'] . '">';
                  echo '<input type="hidden" name="end_padrao" value="' . $lista['end_padrao'] . '">';
                  echo '<input type="hidden" name="end_ativo" value="' . $lista['end_ativo'] . '">';
               }
            ?>
         </form>

         <br>
      </div>

      <?php include ('includes/rodape.php'); ?>

   </div>

   <?php include ('bibliotecasjs.php'); ?>
</body>
</html>