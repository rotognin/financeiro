<?php
	include_once('verifica.php');
   header('Content-Type: text/html; charset=utf-8');

   $_SESSION['msg_erro'] = '';
   require_once('includes/conexao/conexao.class.php');

   $endereco = '';

   // Ler o endereço atual
   if ($conn = Conexao::abrir()) {
      $comando = 'SELECT end_descricao FROM enderecos_tb WHERE end_id = ' . $_SESSION['end_usu_logado'];
      $resultado = $conn->query($comando);
      $lista = $resultado->fetch(PDO::FETCH_ASSOC);
      $endereco = $lista['end_descricao'];
   }
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
             <li><strong>In&iacute;cio</strong></li>
             <li>Endereço atual: <em><?php echo $endereco; ?></em>&nbsp;&nbsp;<a href="escolher_endereco.php">(alterar)</a></li>
          </ol>
      </head>

        <section id="fin_conteudo">

           <ol class="breadcrumb efeito-well2 mg-bottom-10">
              <li>Movimentações Financeiras</li>
              <!--li id="qtd_bancos">Bancos: 2</li-->
              <!--li id="periodo_sel">Período: de 01/01/2015 até 20/05/2015</li-->
              <!--li><a href="alterar_periodo.php">Alterar Período</a></li>
              <li id="periodo_tip"><strong>Período Total/Parcial</strong></li-->
           </ol>

           <?php include_once('includes/flashmsg.php');?>

           <hr class="menos_margem">

           <div id="dados">
              <div id="cabecalho_dados">

                 <div class="hidden-xs">
                    <div class="mov_local_in">
                       <div class="mov_tit_local_in">Locais</div>
                    </div>

                    <div class="mov_compra_in">
                       <div class="mov_tit_compra_in">Compras</div>
                    </div>

                    <div class="mov_venda_in">
                       <div class="mov_tit_venda_in">Vendas</div>
                    </div>

                    <div class="mov_entrada_in">
                       <div class="mov_tit_entrada_in">Entradas</div>
                    </div>

                    <div class="mov_saida_in">
                       <div class="mov_tit_saida_in">Saídas</div>
                    </div>

                    <div class="mov_transferencia_in">
                       <div class="mov_tit_transferencia_in">Transferências</div>
                    </div>

                    <div class="mov_saldo_in">
                       <div class="mov_tit_saldo_in">Saldo</div>
                    </div>
                 </div>

                 <div class="visible-xs-block">
                    <div class="mov_local_in_xs">
                       <div class="mov_tit_local_in_xs">Locais</div>
                    </div>

                    <div class="mov_saldo_in_xs">
                       <div class="mov_tit_saldo_in_xs">Saldo</div>
                    </div>
                 </div>


                 <div id="clear_float"></div>
              </div>

              <hr class="menos_margem">

              <div id="dados_locais"><br><br><br><br><i class="fa fa-spinner fa-pulse fa-3x"></i><h4>Aguarde, carregando...</h4>
              <!-- Aqui vão os dados trazidos pelo Ajax -->
              </div>
           </div>

           <div id="clear_float"></div>
        </section>

        <?php include ('includes/rodape.php'); ?>

    </div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalhes da movimentação</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

    <?php include ('bibliotecasjs.php'); ?>

    <script>
        $(document).ready(function(){
           // Ajax para trazer o locais montados dentro da div Dados
           $.get("buscar_locais.php",{tipo:"bancos"},function(retorno){
              $("#dados_locais").html(retorno);

              $("a.destacar div").click(function(){
                 var debcre = $(this).data("debcre");
                 var codlocal = $(this).data("local");
                 var tipo = $(this).data("tipo");

                 $("div.modal-body").html('<i class="fa fa-spinner fa-pulse fa-2x"></i>&nbsp;&nbsp;Aguarde...');

                 $.get("carregar_dados.php",{tipomov:debcre,local:codlocal,mov:tipo},function(resultado){
                    $("div.modal-body").html(resultado);
                 });
              });

              // Verificar para arrumar essa questão aqui....
              /*$("button#repesquisa").click(function(){
                 var mes_p = $("#mes_pesquisa option:selected").val();
                 var ano_p = $("#ano_pesquisa option:selected").val();

                 $.get("carregar_dados_pesquisa.php",{tipomov:debcre,local:codlocal,mov:tipo,pmes:mes_p,pano:ano_p},function(resultado){
                    $("div.modal-body").html(resultado);
                 });
              });*/

              $("a.destacar li").click(function(){
                 var debcre = $(this).data("debcre");
                 var codlocal = $(this).data("local");
                 var tipo = $(this).data("tipo");

                 $("div.modal-body").html('<i class="fa fa-spinner fa-pulse fa-2x"></i>&nbsp;&nbsp;Aguarde...');

                 $.get("carregar_dados.php",{tipomov:debcre,local:codlocal,mov:tipo},function(resultado){
                    $("div.modal-body").html(resultado);
                 });
              });

              // Função para exibir dados adicionais quando em ambientes menores
              $("div.mov_local_in_xs").click(function(){
                 var codigo = $(this).data("codigo");
                 var altera = "ul#" + codigo;
                 $(altera).slideToggle("fast");
              });
           });
        });
    </script>
</body>
</html>