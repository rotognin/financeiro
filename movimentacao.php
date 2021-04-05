<?php
	include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $tipos = array(
      'Compra' => 'compra',
      'Venda' => 'venda',
      'Transferência' => 'transferencia',
      'Entrada' => 'entrada',
      'Saída' => 'saida');

   if (!in_array($_GET['tipo'],$tipos)) {
      header ('Location: principal.php');
   }

   $tipo = array_search($_GET['tipo'], $tipos);

   // Montar dois arrays com os locais cadastrados de acordo com o
   // tipo de movimentação escolhida

   if (!$conn = Conexao::abrir()) {
      $_SESSION['msg_erro'] = 'Erro ao coectar ao banco.';
      header ('Location: principal.php');
      exit;
   }

   $comando1 = '';
   $comando2 = '';
   $label1 = '';
   $label2 = '';

   switch ($tipo) {
      case 'Compra': {
         $comando1 = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' .
                     $_SESSION['usu_logado'] . ' AND (loc_end_usu = ' .
                     $_SESSION['end_usu_logado'] . ' OR loc_universal = "S") ' .
                     ' AND loc_ativo = "S" AND ' .
                     'loc_banco = "N"';

         $label1 = 'Local da compra:';

         $comando2 = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' .
                     $_SESSION['usu_logado'] . ' AND loc_ativo = "S" AND ' .
                     'loc_banco = "S"';

         $label2 = 'Local de débito:';

         break;
      }
      case 'Venda': {
         $comando1 = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' .
                     $_SESSION['usu_logado'] . ' AND loc_ativo = "S" AND ' .
                     'loc_banco = "S"';

         $label1 = 'Local de crédito:';

         break;
      }
      case 'Transferência': {
         $comando1 = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' .
                     $_SESSION['usu_logado'] . ' AND loc_ativo = "S" AND ' .
                     'loc_banco = "S"';

         $label1 = 'Local de crédito:';

         $comando2 = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' .
                     $_SESSION['usu_logado'] . ' AND loc_ativo = "S" AND ' .
                     'loc_banco = "S"';

         $label2 = 'Local de débito:';

         break;
      }
      case 'Entrada': {
         $comando1 = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' .
                     $_SESSION['usu_logado'] . ' AND loc_ativo = "S" AND ' .
                     'loc_banco = "S"';

         $label1 = 'Local de crédito:';

         break;
      }
      case 'Saída': {
         $comando1 = 'SELECT * FROM locais_tb WHERE loc_usu_id = ' .
                     $_SESSION['usu_logado'] . ' AND loc_ativo = "S" AND ' .
                     'loc_banco = "S"';

         $label1 = 'Local de débito:';

         break;
      }
   }

   $lista1 = array();
   $lista2 = array();

   // Montar um ou dois array´s de acordo com o tipo de movimentação escolhido
   if ($comando1 != '') {
      $resultado1 = $conn->query($comando1);

      while($lista = $resultado1->fetch(PDO::FETCH_ASSOC)) {
         $lista1[] = $lista;
      }
   }

   if ($comando2 != '') {
      $resultado2 = $conn->query($comando2);
      while($lista = $resultado2->fetch(PDO::FETCH_ASSOC)){
         $lista2[] = $lista;
      }
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
            <li><a href="principal.php">Início</a></li>
            <li><strong>Movimentação: <?php echo $tipo; ?></strong></li>
         </ol>
      </head>

        <section id="fin_conteudo">
           <br>

           <?php include ('includes/flashmsg.php'); ?>

           <form class="navbar-form" action="grava_movimentacao.php" name="form_mov" method="POST" id="form_mov" autocomplete="off">

              <div class="input-group">
                 <label for="descricao" class="sr-only">Descrição: </label>
                 <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                 <input class="form-control" type="text" name="descricao" required autofocus placeholder="Descrição">
              </div>

              <br><br>

              <div class="input-group">
                 <label for="valor" class="sr-only">Valor: </label>
                 <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                 <input class="form-control" type="text" name="valor" id="valor_mov" required placeholder="Valor">
              </div>

              <?php
                 // Fazer as verificações
                 // - Compra: Local de Entrada/Crédito (não-banco)
                 //           Local de Saída/Débito (banco)
                 // - Entrada de Valor: Local de Entrada (banco)
                 // - Venda: Local de Entrada/Crédito (banco)
                 // - Transferência: Local de Entrada/Crédito (banco)
                 //                  Local de Saída/Débito (banco)
                 // - Saída de valor: Local de Saída/Débito (banco)

                 if (count($lista1) > 0) {
                    echo '<br><br>';
                    echo '<label>' . $label1 . '</label><br>';
                    echo '<select class="select_mov form-control" name="local1">';

                    foreach ($lista1 as $valor) {
                       echo '<option value="' . $valor['loc_id'] . '">' .
                            $valor['loc_descricao'] . '</option>';
                    }

                    echo '</select>';
                 }

                 if (count($lista2) > 0) {
                    echo '<br><br>';
                    echo '<label>' . $label2 . '</label><br>';
                    echo '<select class="select_mov form-control" name="local2">';

                    foreach ($lista2 as $valor) {
                       echo '<option value="' . $valor['loc_id'] . '">' .
                            $valor['loc_descricao'] . '</option>';
                    }

                    echo '</select>';
                 }
              ?>

              <br><br><br>

              <p>
                 <button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Gravar</button>
                 <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
              </p>

           </form>

        </section>

        <br>

        <?php include ('includes/rodape.php'); ?>
    </div>

    <?php include ('bibliotecasjs.php'); ?>

    <script src="jquery/jquery.maskMoney.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function(){
         $("#valor_mov").maskMoney({showSymbol:true, symbol:"R$", decimal:".", thousands:","}).css({"text-align":"right"});
      });
    </script>
</body>
</html>