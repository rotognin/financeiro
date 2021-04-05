<?php
	include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: principal.php');
      exit;
   }

   $comando = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' . $_SESSION['usu_logado'];
?>

<!doctype html>
<html>
<?php include_once('includes/head_padrao.php'); ?>

<body>
	<div id="principal" class="container-fluid">
    	<head>
         <?php include('menu-interno.php'); ?>

            <ol class="breadcrumb efeito-well mg-bottom-10">
               <li><?php echo $_SESSION['usu_nome']; ?>&nbsp;&nbsp;<a href="logout.php">(Sair)</a></li>
               <li><a href="principal.php">In&iacute;cio</a></li>
               <li><strong>Listagem de Locais</strong>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;<a href="novo_local.php">Adicionar novo Local</a></li>
            </ol>
        </head>

        <?php include_once('includes/flashmsg.php');?>

        <section id="fin_conteudo">
           <div id="cabecalho_local" class="visible-lg-block visible-md-block">
              <div id="cab_local_id">ID</div>
              <div id="cab_local_descricao">Descrição</div>
              <div id="cab_local_observacao">Observação</div>
              <div id="cab_local_endereco">Endereço</div>
              <div id="cab_local_universal">Universal?</div>
              <div id="cab_local_banco">Banco?</div>
              <div id="cab_local_ativo">Ativo?</div>
              <div id="cab_local_alterar">Alterar</div>
              <div id="clear_float"></div>
           </div>

           <div id="cabecalho_local_sm" class="visible-sm-block">
              <div id="cab_local_id_sm">ID</div>
              <div id="cab_local_descricao_sm">Descrição</div>
              <div id="cab_local_universal_sm">Universal?</div>
              <div id="cab_local_banco_sm">Banco?</div>
              <div id="cab_local_ativo_sm">Ativo?</div>
              <div id="cab_local_alterar_sm">Alterar</div>
              <div id="clear_float"></div>
           </div>

           <div id="cabecalho_local_xs" class="visible-xs-block">
              <div id="cab_local_id_xs">ID</div>
              <div id="cab_local_descricao_xs">Descrição</div>
           </div>

           

           <div id="dados_local">

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
                          <div id="dad_local_id"><?php echo $linha['loc_id']; ?></div>
                          <div id="dad_local_descricao"><?php echo $linha['loc_descricao']; ?></div>
                          <div id="dad_local_observacao"><?php echo $linha['loc_observacao']; ?></div>
                          <div id="dad_local_endereco">
                          <?php
                             // Ler o endereço cadastrado para aquele local
                             $ler_end = 'SELECT end_descricao FROM enderecos_tb WHERE end_id = ' . $linha['loc_end_usu'];
                             $endereco = $conn->query($ler_end);
                             $desc = $endereco->fetch(PDO::FETCH_BOTH);
                             echo $desc[0];
                          ?>
                          </div>
                          <div id="dad_local_universal"><?php if ($linha['loc_universal'] == 'S') { echo 'SIM'; } else { echo 'NÃO'; } ?></div>
                          <div id="dad_local_banco"><?php if ($linha['loc_banco'] == 'S') { echo 'SIM'; } else { echo 'NÃO'; } ?></div>
                          <div id="dad_local_ativo">
                          <?php
                             if ($linha['loc_ativo'] == 'S') { echo 'SIM '; } else { echo 'NÃO '; }
                          ?>
                             <button type="button"
                          <?php if ($linha['loc_ativo'] == 'S') { echo ' class="btn btn-danger btn-sm" '; } else { echo ' class="btn btn-primary btn-sm" '; } ?>
                                     data-local-id="<?php echo $linha['loc_id']; ?>"
                                     data-atual="<?php echo $linha['loc_ativo']; ?>">
                                <?php $valor = ($linha['loc_ativo'] == 'S') ? 'Inativar' : 'Ativar'; echo $valor; ?>
                             </button>
                          </div>
                          <div id="dad_local_alterar"><a class="btn btn-success btn-sm" href="novo_local.php?altera=<?php echo $linha['loc_id'] ?>">Alterar</a></div>

                          <div id="clear_float"></div>
                       </div>
                    </div>

                    <div class="visible-sm-block">
                       <div class="impar mg-bottom-5">
                          <div id="dad_local_id_sm"><?php echo $linha['loc_id']; ?></div>
                          <div id="dad_local_descricao_sm"><?php echo $linha['loc_descricao']; ?></div>
                          <div id="dad_local_universal_sm"><?php if ($linha['loc_universal'] == 'S') { echo 'SIM'; } else { echo 'NÃO'; } ?></div>
                          <div id="dad_local_banco_sm"><?php if ($linha['loc_banco'] == 'S') { echo 'SIM'; } else { echo 'NÃO'; } ?></div>
                          <div id="dad_local_ativo_sm">
                          <?php
                             if ($linha['loc_ativo'] == 'S') { echo 'SIM '; } else { echo 'NÃO '; }
                          ?>
                             <button type="button"
                          <?php if ($linha['loc_ativo'] == 'S') { echo ' class="btn btn-danger btn-sm" '; } else { echo ' class="btn btn-primary btn-sm" '; } ?>
                                     data-local-id="<?php echo $linha['loc_id']; ?>"
                                     data-atual="<?php echo $linha['loc_ativo']; ?>">
                                <?php $valor = ($linha['loc_ativo'] == 'S') ? 'Inativar' : 'Ativar'; echo $valor; ?>
                             </button>
                          </div>
                          <div id="dad_local_alterar_sm"><a class="btn btn-success btn-sm" href="novo_local.php?altera=<?php echo $linha['loc_id'] ?>">Alterar</a></div>

                          <div id="clear_float"></div>
                       </div>
                    </div>

                    <div class="visible-xs-block">
                       <div class="mg-bottom-5 abrir-det-local" data-codigo="<?php echo $linha['loc_id']; ?>">
                          <a href="javascript:;"><div id="dad_local_id_xs"><?php echo $linha['loc_id']; ?></div>
                          <div id="dad_local_descricao_xs"><?php echo $linha['loc_descricao']; ?></div></a>
                          <div id="clear_float"></div>
                       </div>
                       
                       <ul class="sem-lista escondido sem-fundo" id="<?php echo $linha['loc_id']; ?>">
                          <li><?php echo $linha['loc_observacao']; ?></li>
                          <li>
                             <?php 
                                echo 'Universal? &nbsp;&nbsp;&nbsp;'; 
                                if ($linha['loc_universal'] == 'S') { 
                                   echo 'SIM'; 
                                } else { 
                                   echo 'NÃO'; 
                                } ?>
                          </li>
                          <li>
                             <?php 
                                echo 'Banco? &nbsp;&nbsp;&nbsp;'; 
                                if ($linha['loc_banco'] == 'S') { 
                                   echo 'SIM'; 
                                } else { 
                                   echo 'NÃO'; 
                                } ?>
                          </li>
                          <li id="dad_local_ativo_xs">
                             <?php echo 'Ativo? &nbsp;&nbsp;&nbsp;';
                                if ($linha['loc_ativo'] == 'S') { echo 'SIM '; } else { echo 'NÃO '; }
                             ?>
                                <button type="button"
                             <?php if ($linha['loc_ativo'] == 'S') { echo ' class="btn btn-danger btn-sm" '; } else { echo ' class="btn btn-primary btn-sm" '; } ?>
                                     data-local-id="<?php echo $linha['loc_id']; ?>"
                                     data-atual="<?php echo $linha['loc_ativo']; ?>">
                                <?php $valor = ($linha['loc_ativo'] == 'S') ? 'Inativar' : 'Ativar'; echo $valor; ?>
                             </button>
                          </li>
                          <li><a class="btn btn-success btn-sm" href="novo_local.php?altera=<?php echo $linha['loc_id'] ?>">Alterar</a><br><hr class="menos_margem2"></li>
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
         $("div#dad_local_ativo button").click(function(){
            var id_local_alt = $(this).data("local-id");
            var sit_local = $(this).data("atual");
            var nova_situacao = (sit_local == 'S') ? 'N' : 'S';

            $.get("alterar_situacao_local.php",{id_local:id_local_alt,situacao:nova_situacao},function(retorno){
               window.location.href = 'lista_local.php';
            });
         });
         
         $("div#dad_local_ativo_sm button").click(function(){
            var id_local_alt = $(this).data("local-id");
            var sit_local = $(this).data("atual");
            var nova_situacao = (sit_local == 'S') ? 'N' : 'S';

            $.get("alterar_situacao_local.php",{id_local:id_local_alt,situacao:nova_situacao},function(retorno){
               window.location.href = 'lista_local.php';
            });
         });
         
         $("li#dad_local_ativo_xs button").click(function(){
            var id_local_alt = $(this).data("local-id");
            var sit_local = $(this).data("atual");
            var nova_situacao = (sit_local == 'S') ? 'N' : 'S';

            $.get("alterar_situacao_local.php",{id_local:id_local_alt,situacao:nova_situacao},function(retorno){
               window.location.href = 'lista_local.php';
            });
         });
         
         $("div.abrir-det-local").click(function(){
            var codigo = $(this).data("codigo");
            var altera = "ul#" + codigo;
            $(altera).slideToggle("fast");
         });
      });
    </script>
</body>
</html>