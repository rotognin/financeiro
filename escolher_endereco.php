<?php
	include_once('verifica.php');

   if (isset($_GET['utilizar'])) {
      $_SESSION['end_usu_logado'] = $_GET['utilizar'];
      header ('Location: principal.php');
      exit;
   }

   // Arquivo de conexão com o banco de dados
   $volta_erro = 'erro.php';
   require_once('includes/conexao/conexao_pdo.php');

   $comando = 'SELECT * FROM enderecos_tb WHERE end_usu_id = ' .
              $_SESSION['usu_logado'] . ' AND end_ativo = "S"';
              // AND end_padrao = "S"';

?>

<!doctype html>
<html>
<?php include_once('includes/head_padrao.php'); ?>

<body>
	<div id="principal" class="container-fluid">
    	<head>
         <?php
            if (isset($_SESSION['end_usu_logado']) && $_SESSION['end_usu_logado']) {
               include('menu-interno.php');
            }
            else {
         ?>
            <div class="alert alert-info alert-dismissible  mg-bottom-10" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <strong>Aviso: </strong> você precisa selecionar um endereço a ser utilizado.
            </div>
         <?php
            }
         ?>

            <ol class="breadcrumb efeito-well mg-bottom-10">
               <li><?php echo $_SESSION['usu_nome']; ?>&nbsp;&nbsp;<a href="logout.php">(Sair)</a></li>

               <?php
                  // Se o operador já tiver um endereço sendo utilizado, irá mostrar
                  // que ele veio da página principal.
                  if (isset($_SESSION['end_usu_logado']) && $_SESSION['end_usu_logado']) {
               ?>
                     <li><a href="principal.php">In&iacute;cio</a></li>
               <?php
                  }
               ?>

               <li><strong>Selecionar Endereço</strong></li>
            </ol>
        </head>

        <section id="fin_conteudo">
           <div id="cabecalho_enderecos" class="visible-lg-block visible-md-block">
              <div id="cab_end2_selecionar">Selecione</div>
              <div id="cab_end2_id">ID</div>
              <div id="cab_end2_descricao">Descrição</div>
              <div id="cab_end2_cidade">Cidade</div>
              <div id="cab_end2_estado">UF</div>
              <div id="cab_end2_ativo">Ativo?</div>
              <div id="cab_end2_padrao">Padrão?</div>
              <div id="clear_float"></div>
           </div>

           <div id="cabecalho_enderecos" class="visible-sm-block">
              <div id="cab_end2_selecionar_sm">Selecione</div>
              <div id="cab_end2_id_sm">ID</div>
              <div id="cab_end2_descricao_sm">Descrição</div>
              <div id="cab_end2_ativo_sm">Ativo?</div>
              <div id="cab_end2_padrao_sm">Padrão?</div>
              <div id="clear_float"></div>
           </div>
           
           <div id="cabecalho_enderecos" class="visible-xs-block">
              <div id="cab_end2_selecionar_xs">Selecione</div>
              <div id="cab_end2_id_xs">ID</div>
              <div id="cab_end2_descricao_xs">Descrição</div>
              <div id="clear_float"></div>
           </div>
           
           <hr>

           <div id="dados_enderecos">

           <?php
              $resultado = $conn->query($comando);

              if ($resultado->rowCount() > 0)
              {
                 // Loop para listar todos os registros
                 foreach ($conn->query($comando) as $linha)
                 {
           ?>
                    <div class="visible-lg-block visible-md-block">
                       <div class="impar mg-bottom-5">
                          <div id="dad_end2_selecionar"><a class="btn btn-success btn-sm" href="escolher_endereco.php?utilizar=<?php echo $linha['end_id'] ?>">Utilizar</a></div>
                          <div id="dad_end2_id"><?php echo $linha['end_id']; ?></div>
                          <div id="dad_end2_descricao"><?php echo $linha['end_descricao']; ?></div>
                          <div id="dad_end2_cidade"><?php echo $linha['end_cidade']; ?></div>
                          <div id="dad_end2_estado"><?php echo $linha['end_estado']; ?></div>
                          <div id="dad_end2_ativo">
                             <?php
                                if ($linha['end_ativo'] == 'S') {
                                   echo 'SIM';
                                }
                                else {
                                   echo 'NÃO';
                                }
                             ?>
                          </div>
                          <div id="dad_end2_padrao">
                             <?php
                                if ($linha['end_padrao'] == 'S') {
                                   echo 'SIM';
                                }
                                else {
                                   echo 'NÃO';
                                }
                             ?>
                          </div>

                          <div id="clear_float"></div>
                       </div>
                    </div>
                    
                    <div class="visible-sm-block">
                       <div class="impar mg-bottom-5">
                          <div id="dad_end2_selecionar_sm"><a class="btn btn-success btn-sm" href="escolher_endereco.php?utilizar=<?php echo $linha['end_id'] ?>">Utilizar</a></div>
                          <div id="dad_end2_id_sm"><?php echo $linha['end_id']; ?></div>
                          <div id="dad_end2_descricao_sm"><?php echo $linha['end_descricao']; ?></div>
                          <div id="dad_end2_ativo_sm">
                             <?php
                                if ($linha['end_ativo'] == 'S') {
                                   echo 'SIM';
                                }
                                else {
                                   echo 'NÃO';
                                }
                             ?>
                          </div>
                          <div id="dad_end2_padrao_sm">
                             <?php
                                if ($linha['end_padrao'] == 'S') {
                                   echo 'SIM';
                                }
                                else {
                                   echo 'NÃO ';
                                }
                             ?>
                          </div>

                          <div id="clear_float"></div>
                       </div>
                    </div>
                    
                    <div class="visible-xs-block">
                       <div class="mg-bottom-5 abrir-det-end2" data-codigo="<?php echo $linha['end_id']; ?>">
                          <a href="javascript:;">
                             <div id="dad_end2_selecionar_xs"><a class="btn btn-success btn-sm" href="escolher_endereco.php?utilizar=<?php echo $linha['end_id'] ?>">Utilizar</a></div>
                             <div id="dad_end2_id_xs"><?php echo $linha['end_id']; ?></div>
                             <div id="dad_end2_descricao_xs"><?php echo $linha['end_descricao']; ?></div>
                          </a>
                          <div id="clear_float"></div>
                       </div>
                       
                       <ul class="sem-lista escondido sem-fundo" id="<?php echo $linha['end_id']; ?>">
                          <li>Cidade:&nbsp;&nbsp;&nbsp;<?php echo $linha['end_cidade']; ?></li>
                          <li>UF:&nbsp;&nbsp;&nbsp;<?php echo $linha['end_estado']; ?></li>
                          <li id="dad_end_ativo_xs">Ativo?&nbsp;&nbsp;
                             <?php
                                if ($linha['end_ativo'] == 'S') {
                                   echo 'SIM';
                                }
                                else {
                                   echo 'NÃO';
                                }
                             ?>
                          </li>

                          <li id="dad_end_padrao_xs">Padrão?&nbsp;&nbsp;
                             <?php
                                if ($linha['end_padrao'] == 'S') {
                                   echo 'SIM';
                                }
                                else {
                                   echo 'NÃO';
                                }
                             ?>
                          </li>
                          <li>
                             <a class="btn btn-success btn-sm" href="novo_endereco.php?altera=<?php echo $linha['end_id'] ?>">Alterar</a>
                             <br><hr class="menos_margem2">
                          </li>
                       </ul>
                       
                       <hr class="menos_margem2">
                   </div>
                    
           <?php
                 }
              }
           ?>

           </div>

           <div id="clear_float"></div>

        </section>

        <?php include ('includes/rodape.php'); ?>
    </div>

    <?php include ('bibliotecasjs.php'); ?>

    <script>
       $(document).ready(function(){
           $("div#dad_end2_ativo button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"ativo",id:qual,valor:atual},function(retorno){
                 window.location.href = 'escolher_endereco.php';
              });
           });
           
           $("div#dad_end2_ativo_sm button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_ativo",id:qual,valor:atual},function(retorno){
                 window.location.href = 'escolher_endereco.php';
              });
           });

           $("div#dad_end2_ativo_xs button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_ativo",id:qual,valor:atual},function(retorno){
                 window.location.href = 'escolher_endereco.php';
              });
           });

           $("div#dad_end2_padrao button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"padrao",id:qual,valor:atual},function(retorno){
                 window.location.href = 'escolher_endereco.php';
              });
           });
           
           $("div#dad_end2_padrao_sm button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_padrao",id:qual,valor:atual},function(retorno){
                 window.location.href = 'escolher_endereco.php';
              });
           });

           $("div#dad_end2_padrao_xs button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_padrao",id:qual,valor:atual},function(retorno){
                 window.location.href = 'escolher_endereco.php';
              });
           });

           $("div.abrir-det-end2").click(function(){
            var codigo = $(this).data("codigo");
            var altera = "ul#" + codigo;
            $(altera).slideToggle("fast");
         });
       });
    </script>
</body>
</html>