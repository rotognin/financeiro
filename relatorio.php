<?php
	include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: principal.php');
      exit;
   }

   // Montar o Select aqui dependendo do tipo de relatório selecionado
   $tipo_rel = $_GET['tipo'];
   $comando = '';
   $tipo_real = '';
   $endereco = $_GET['end'];

   switch ($tipo_rel)
   {
      case 'compra': {
         $comando = 'SELECT M.mov_id, M.mov_data_hora, M.mov_descricao, M.mov_valor_credito, ' .
                    'L1.loc_descricao, L2.loc_descricao, E.end_descricao, E.end_id ' .
                    'FROM movimentos_tb M ' .
                    'INNER JOIN locais_tb L1 ON M.mov_local_credito = L1.loc_id ' .
                    'INNER JOIN locais_tb L2 ON M.mov_local_debito = L2.loc_id ' .
                    'INNER JOIN enderecos_tb E ON M.mov_end_usu = E.end_id ' .
                    'WHERE M.mov_usu_id = ' . $_SESSION['usu_logado'] . ' AND ' .
                    'M.mov_tipo = "' . $tipo_rel . '"';
         $tipo_real = 'Compra';
         break;
      }
      case 'venda': {
         $comando = 'SELECT M.mov_id, M.mov_data_hora, M.mov_descricao, M.mov_valor_credito, ' .
                    'L1.loc_descricao, E.end_descricao, E.end_id ' .
                    'FROM movimentos_tb M ' .
                    'INNER JOIN locais_tb L1 ON M.mov_local_credito = L1.loc_id ' .
                    'INNER JOIN enderecos_tb E ON M.mov_end_usu = E.end_id ' .
                    'WHERE M.mov_usu_id = ' . $_SESSION['usu_logado'] . ' AND ' .
                    'M.mov_tipo = "' . $tipo_rel . '"';
         $tipo_real = 'Venda';
         break;
      }
      case 'entrada': {
         $comando = 'SELECT M.mov_id, M.mov_data_hora, M.mov_descricao, M.mov_valor_credito, ' .
                    'L1.loc_descricao, E.end_descricao, E.end_id ' .
                    'FROM movimentos_tb M ' .
                    'INNER JOIN locais_tb L1 ON M.mov_local_credito = L1.loc_id ' .
                    'INNER JOIN enderecos_tb E ON M.mov_end_usu = E.end_id ' .
                    'WHERE M.mov_usu_id = ' . $_SESSION['usu_logado'] . ' AND ' .
                    'M.mov_tipo = "' . $tipo_rel . '"';
         $tipo_real = 'Entrada';
         break;
      }
      case 'saida': {
         $comando = 'SELECT M.mov_id, M.mov_data_hora, M.mov_descricao, M.mov_valor_debito, ' .
                    'L1.loc_descricao, E.end_descricao, E.end_id ' .
                    'FROM movimentos_tb M ' .
                    'INNER JOIN locais_tb L1 ON M.mov_local_debito = L1.loc_id ' .
                    'INNER JOIN enderecos_tb E ON M.mov_end_usu = E.end_id ' .
                    'WHERE M.mov_usu_id = ' . $_SESSION['usu_logado'] . ' AND ' .
                    'M.mov_tipo = "' . $tipo_rel . '"';
         $tipo_real = 'Saída';
         break;
      }
      case 'transferencia': {
         $comando = 'SELECT M.mov_id, M.mov_data_hora, M.mov_descricao, M.mov_valor_credito, ' .
                    'L1.loc_descricao, L2.loc_descricao, E.end_descricao, E.end_id ' .
                    'FROM movimentos_tb M ' .
                    'INNER JOIN locais_tb L1 ON M.mov_local_credito = L1.loc_id ' .
                    'INNER JOIN locais_tb L2 ON M.mov_local_debito = L2.loc_id ' .
                    'INNER JOIN enderecos_tb E ON M.mov_end_usu = E.end_id ' .
                    'WHERE M.mov_usu_id = ' . $_SESSION['usu_logado'] . ' AND ' .
                    'M.mov_tipo = "' . $tipo_rel . '"';
         $tipo_real = 'Transferência';
         break;
      }
   }

   // Filtrar pelo endereço
   $mensagem_adicional = '';

   if ($endereco != 'nao') {
      $comando .= ' AND M.mov_end_usu = ' . (int)$endereco;
      $mensagem_adicional = 'Filtrando por Endereço';
   }

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
               <li>Relatório de movimentos: <strong><?php echo $tipo_real; ?></strong></li>
               <?php if ($mensagem_adicional != '') {
                        echo '<li>' . $mensagem_adicional . ' - <strong><a href="relatorio.php?tipo=' . $tipo_rel . '&end=nao">Exibir todos</a></strong></li>';
                     }
               ?>
           </ol>
        </head>

        <?php include_once('includes/flashmsg.php');?>

        <section id="fin_conteudo">
           <div id="cabecalho_relatorio" class="visible-lg-block visible-md-block">
              <div id="cab_rel_data">Data</div>
              <div id="cab_rel_hora">Hora</div>
              <div id="cab_rel_descricao">Descrição</div>
              <div id="cab_rel_valor">Valor</div>
              <div id="cab_rel_loc_credito">Local Crédito</div>
              <div id="cab_rel_loc_debito">Local Débito</div>
              <div id="cab_rel_endereco">Endereço</div>
           </div>

           <div id="cabecalho_relatorio_sm" class="visible-sm-block visible-xs-block">
              <div id="cab_rel_data_sm">Data</div>
              <div id="cab_rel_descricao_sm">Descrição</div>
           </div>

           <div id="clear_float"></div>
           <hr>

           <div id="dados_relatorio">

           <?php
              $resultado = $conn->query($comando);

              if ($resultado->rowCount() > 0)
              {
                 // Loop para listar todos os registros
                 while ($linha = $resultado->fetch(PDO::FETCH_NUM))
                 {
                    // Formatar os resultados
                    $rel_mov_id = $linha[0];

                    $rel_data_hora_1 = explode(' ', $linha[1]);
                    $rel_data_1 = explode('-', $rel_data_hora_1[0]);
                    $rel_hora_1 = explode(':', $rel_data_hora_1[1]);

                    $rel_data = $rel_data_1[2] . '/' .
                                $rel_data_1[1] . '/' .
                                $rel_data_1[0];
                    $rel_hora = $rel_hora_1[0] . ':' .
                                $rel_hora_1[1];

                    $rel_descricao = $linha[2];
                    $rel_valor = $linha[3];

                    switch ($tipo_rel) {
                       case 'compra': {
                          $rel_local_credito = $linha[4];
                          $rel_local_debito = $linha[5];
                          $rel_endereco = $linha[6];
                          $rel_id_endereco = $linha[7];
                          break;
                       }
                       case 'venda': {
                          $rel_local_credito = $linha[4];
                          $rel_local_debito = '-';
                          $rel_endereco = $linha[5];
                          $rel_id_endereco = $linha[6];
                          break;
                       }
                       case 'entrada': {
                          $rel_local_credito = $linha[4];
                          $rel_local_debito = '-';
                          $rel_endereco = $linha[5];
                          $rel_id_endereco = $linha[6];
                          break;
                       }
                       case 'saida': {
                          $rel_local_credito = '-';
                          $rel_local_debito = $linha[4];
                          $rel_endereco = $linha[5];
                          $rel_id_endereco = $linha[6];
                          break;
                       }
                       case 'transferencia': {
                          $rel_local_credito = $linha[4];
                          $rel_local_debito = $linha[5];
                          $rel_endereco = $linha[6];
                          $rel_id_endereco = $linha[7];
                          break;
                       }
                    }
           ?>
                    <div class="visible-lg-block visible-md-block">
                       <div class="menos_margem3">
                          <div id="dad_rel_data"><?php echo $rel_data; ?></div>
                          <div id="dad_rel_hora"><?php echo $rel_hora; ?></div>
                          <div id="dad_rel_descricao"><?php echo $rel_descricao; ?></div>
                          <div id="dad_rel_valor"><?php echo $rel_valor; ?></div>
                          <div id="dad_rel_loc_credito"><?php echo $rel_local_credito; ?></div>
                          <div id="dad_rel_loc_debito"><?php echo $rel_local_debito; ?></div>
                          <div id="dad_rel_endereco"><a href="relatorio.php?tipo=<?php echo $tipo_rel; ?>&end=<?php echo $rel_id_endereco; ?>"><?php echo $rel_endereco; ?></a></div>
                          <div id="clear_float"></div>
                       </div>
                    </div>

                    <div class="visible-sm-block visible-xs-block">
                       <div class="mg-bottom-5 abrir-det-relatorio" data-codigo="<?php echo $rel_mov_id; ?>">
                          <a href="javascript:;"><div id="dad_rel_data_sm"><?php echo $rel_data; ?></div>
                             <div id="dad_rel_descricao_sm"><?php echo $rel_descricao; ?></div>
                          </a>
                          <div id="clear_float"></div>
                       </div>

                       <ul class="sem-lista escondido sem-fundo" id="<?php echo $rel_mov_id; ?>">
                          <li><strong>Hora:</strong>&nbsp;&nbsp;&nbsp;<?php echo $rel_hora; ?></li>
                          <li><strong>Valor:</strong>&nbsp;&nbsp;&nbsp;<?php echo $rel_valor; ?></li>
                          <li><strong>Local Crédito:</strong>&nbsp;&nbsp;&nbsp;<?php echo $rel_local_credito; ?></li>
                          <li><strong>Local Débito:</strong>&nbsp;&nbsp;&nbsp;<?php echo $rel_local_debito; ?></li>
                          <li><strong>Endereço:</strong>&nbsp;&nbsp;&nbsp;<?php echo $rel_endereco; ?><hr></li>
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
           $("div.abrir-det-relatorio").click(function(){
            var codigo = $(this).data("codigo");
            var altera = "ul#" + codigo;
            $(altera).slideToggle("fast");
         });
       });
    </script>
</body>
</html>