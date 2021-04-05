<?php
	include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: principal.php');
      exit;
   }

   $comando = 'SELECT * FROM enderecos_tb WHERE end_usu_id = ' . $_SESSION['usu_logado'];

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
               <li><strong>Endereços</strong>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;<a href="novo_endereco.php">Adicionar novo Endereço</a></li>
           </ol>
        </head>

        <?php include_once('includes/flashmsg.php');?>

        <section id="fin_conteudo">
           <div id="cabecalho_enderecos" class="visible-lg-block visible-md-block">
              <div id="cab_end_id">ID</div>
              <div id="cab_end_descricao">Descrição</div>
              <div id="cab_end_cidade">Cidade</div>
              <div id="cab_end_estado">UF</div>
              <div id="cab_end_ativo">Ativo?</div>
              <div id="cab_end_padrao">Padrão?</div>
              <div id="cab_end_alterar">Alterar</div>
           </div>

           <div id="cabecalho_enderecos_sm" class="visible-sm-block">
              <div id="cab_end_id_sm">ID</div>
              <div id="cab_end_descricao_sm">Descrição</div>
              <div id="cab_end_ativo_sm">Ativo?</div>
              <div id="cab_end_padrao_sm">Padrão?</div>
              <div id="cab_end_alterar_sm">Alterar</div>
           </div>

           <div id="cabecalho_enderecos_xs" class="visible-xs-block">
              <div id="cab_end_id_xs">ID</div>
              <div id="cab_end_descricao_xs">Descrição</div>
           </div>

           <div id="clear_float"></div>
           <hr>

           <div id="dados_enderecos">

           <?php
              $resultado = $conn->query($comando);

              if ($resultado->rowCount() > 0)
              {
                 // Loop para listar todos os registros
                 foreach ($conn->query($comando) as $linha)
                 {

                    if ($linha['end_id'] == $_SESSION['end_usu_logado']) {
                       $tag_em = '<em>';
                       $tag_em_fim = '</em>';
                    } else {
                       $tag_em = '';
                       $tag_em_fim = '';
                    }
           ?>
                    <div class="visible-lg-block visible-md-block">
                       <div class="impar mg-bottom-5">
                          <div id="dad_end_id"><?php echo $linha['end_id']; ?></div>
                          <div id="dad_end_descricao"><?php echo $tag_em . $linha['end_descricao'] . $tag_em_fim; ?></div>
                          <div id="dad_end_cidade"><?php echo $tag_em . $linha['end_cidade'] . $tag_em_fim; ?></div>
                          <div id="dad_end_estado"><?php echo $tag_em . $linha['end_estado'] . $tag_em_fim; ?></div>
                          <div id="dad_end_ativo">
                             <?php
                                if ($linha['end_ativo'] == 'S') {
                                   echo 'SIM - <button type="button" class="btn btn-danger btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="SIM">Inativar</button>';
                                }
                                else {
                                   echo 'NÃO - <button type="button"  class="btn btn-primary btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="NAO">Ativar</button>';
                                }
                             ?>
                          </div>
                          <div id="dad_end_padrao">
                             <?php
                                if ($linha['end_padrao'] == 'S') {
                                   echo 'SIM - <button type="button" class="btn btn-danger btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="SIM">Desativar</button>';
                                }
                                else {
                                   echo 'NÃO - <button type="button" class="btn btn-primary btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="NAO">Ativar</button>';
                                }
                             ?>
                          </div>
                          <div id="dad_end_alterar">
                             <a class="btn btn-success btn-sm" href="novo_endereco.php?altera=<?php echo $linha['end_id'] ?>">Alterar</a>
                          </div>

                          <div id="clear_float"></div>
                       </div>
                    </div>

                    <div class="visible-sm-block">
                       <div class="impar mg-bottom-5">
                          <div id="dad_end_id_sm"><?php echo $linha['end_id']; ?></div>
                          <div id="dad_end_descricao_sm"><?php echo $tag_em . $linha['end_descricao'] . $tag_em_fim; ?></div>
                          <div id="dad_end_ativo_sm">
                             <?php
                                if ($linha['end_ativo'] == 'S') {
                                   echo 'SIM - <button type="button" class="btn btn-danger btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="SIM">Inativar</button>';
                                }
                                else {
                                   echo 'NÃO - <button type="button"  class="btn btn-primary btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="NAO">Ativar</button>';
                                }
                             ?>
                          </div>
                          <div id="dad_end_padrao_sm">
                             <?php
                                if ($linha['end_padrao'] == 'S') {
                                   echo 'SIM - <button type="button" class="btn btn-danger btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="SIM">Desativar</button>';
                                }
                                else {
                                   echo 'NÃO - <button type="button" class="btn btn-primary btn-sm" data-end-id="' . $linha['end_id'] . '" data-atual="NAO">Ativar</button>';
                                }
                             ?>
                          </div>
                          <div id="dad_end_alterar">
                             <a class="btn btn-success btn-sm" href="novo_endereco.php?altera=<?php echo $linha['end_id'] ?>">Alterar</a>
                          </div>

                          <div id="clear_float"></div>
                       </div>
                    </div>

                    <div class="visible-xs-block">
                       <div class="mg-bottom-5 abrir-det-endereco" data-codigo="<?php echo $linha['end_id']; ?>">
                          <a href="javascript:;"><div id="dad_end_id_xs"><?php echo $linha['end_id']; ?></div>
                             <div id="dad_end_descricao_xs"><?php echo $tag_em . $linha['end_descricao'] . $tag_em_fim; ?></div>
                          </a>
                          <div id="clear_float"></div>
                       </div>

                       <ul class="sem-lista escondido sem-fundo" id="<?php echo $linha['end_id']; ?>">
                          <li>Cidade:&nbsp;&nbsp;&nbsp;<?php echo $linha['end_cidade']; ?></li>
                          <li>UF:&nbsp;&nbsp;&nbsp;<?php echo $linha['end_estado']; ?></li>
                          <li id="dad_end_ativo_xs">Ativo?&nbsp;&nbsp;
                             <?php
                                if ($linha['end_ativo'] == 'S') {
                                   echo 'SIM - ';
                                }
                                else {
                                   echo 'NÃO - ';
                                }
                             ?>
                                <button type="button"
                             <?php if ($linha['end_ativo'] == 'S')
                                { echo ' class="btn btn-danger btn-sm" '; } else { echo ' class="btn btn-primary btn-sm" '; }
                             ?>
                                data-end-id="<?php echo $linha['end_id']; ?>"
                                data-atual="<?php echo $linha['end_ativo']; ?>">
                             <?php $valor = ($linha['end_ativo'] == 'S') ? 'Inativar' : 'Ativar'; echo $valor; ?>
                                </button>
                          </li>

                          <li id="dad_end_padrao_xs">Padrão?&nbsp;&nbsp;
                             <?php
                                if ($linha['end_padrao'] == 'S') {
                                   echo 'SIM - ';
                                }
                                else {
                                   echo 'NÃO - ';
                                }
                             ?>
                                <button type="button"
                             <?php if ($linha['end_padrao'] == 'S')
                                { echo ' class="btn btn-danger btn-sm" '; } else { echo ' class="btn btn-primary btn-sm" '; }
                             ?>
                                data-end-id="<?php echo $linha['end_id']; ?>"
                                data-atual="<?php echo $linha['end_padrao']; ?>">
                             <?php $valor = ($linha['end_padrao'] == 'S') ? 'Inativar' : 'Ativar'; echo $valor; ?>
                                </button>
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

           <div id="qualquer"></div>
        </section>

        <?php include ('includes/rodape.php'); ?>
    </div>

    <?php include ('bibliotecasjs.php'); ?>

    <script>
       $(document).ready(function(){
           $("div#dad_end_ativo button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_ativo",id:qual,valor:atual},function(retorno){
                 window.location.href = 'lista_endereco.php';
              });
           });

           $("div#dad_end_ativo_sm button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_ativo",id:qual,valor:atual},function(retorno){
                 window.location.href = 'lista_endereco.php';
              });
           });

           $("li#dad_end_ativo_xs button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_ativo",id:qual,valor:atual},function(retorno){
                 window.location.href = 'lista_endereco.php';
              });
           });

           $("div#dad_end_padrao button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_padrao",id:qual,valor:atual},function(retorno){
                 window.location.href = 'lista_endereco.php';
              });
           });

           $("div#dad_end_padrao_sm button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_padrao",id:qual,valor:atual},function(retorno){
                 window.location.href = 'lista_endereco.php';
              });
           });

           $("li#dad_end_padrao_xs button").click(function(){
              var qual = $(this).data("end-id");
              var atual = $(this).data("atual");

              $.get("altera_end.php",{acao:"end_padrao",id:qual,valor:atual},function(retorno){
                 window.location.href = 'lista_endereco.php';
              });
           });

           $("div.abrir-det-endereco").click(function(){
            var codigo = $(this).data("codigo");
            var altera = "ul#" + codigo;
            $(altera).slideToggle("fast");
         });
       });
    </script>
</body>
</html>