<?php
	include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   // Utilizado para alterar caso tenha vindo uma variável via GET
   $alterar = false;

   if (isset($_GET['altera'])) {
      $loc_id = intval($_GET['altera']);
      $alterar = true;

      if (!$conn = Conexao::abrir()) {
         $_SESSION['msg_erro'] = 'Não foi possível conectar ao banco.';
         header ('Location: lista_local.php');
         exit;
      }

      $comando = 'SELECT * FROM locais_tb WHERE loc_id = ' . $loc_id;
      $resultado = $conn->query($comando);

      if ($resultado->rowCount() != 1) {
         $_SESSION['msg_erro'] = 'Registro não localizado no banco.';
         header ('Location: lista_local.php');
         exit;
      }

      $lista = $resultado->fetch(PDO::FETCH_ASSOC);
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
            <li><a href="lista_local.php">Locais</a></li>
            <li><strong><?php if ($alterar) { echo 'Alterar '; } else { echo 'Novo '; } ?> Local</strong></li>
         </ol>
      </head>

        <section id="fin_conteudo">

        <?php
           include ('includes/flashmsg.php');
        ?>
           <div class="alert alert-info">Todos os locais cadastrados que não forem identificados como "Banco" (carteira) e
              que não estiverem com a marcação "Universal",
              estarão vinculados ao endereço atual que você estiver utilizando.</div>

           <form class="navbar-form" action="
           <?php
              if ($alterar) {
                 echo 'altera_local.php';
              }
              else {
                 echo 'insere_local.php';
              }
              ?>" name="form_local" method="POST" id="form_novo_local">

              <div class="input-group mg-bottom-10">
                 <label for="descricao" class="sr-only">Descrição: </label>
                 <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                 <input class="form-control" type="text" name="descricao" required autofocus
                  placeholder="Descrição"
                 <?php
                    if ($alterar) {
                       echo 'value="' . $lista['loc_descricao'] . '"';
                    }
                 ?>>
              </div>
              <br>
              <div class="input-group mg-bottom-10">
                 <label for="observacao" class="sr-only">Observação: </label>
                 <span class="input-group-addon"><span class="glyphicon glyphicon-align-left" aria-hidden="true"></span></span>
                 <input class="form-control" type="text" name="observacao"
                  placeholder="Observação" 
                 <?php
                    if ($alterar) {
                       echo 'value="' . $lista['loc_observacao'] . '"';
                    }
                 ?>>
              </div>
              <br>
              <?php
                 $loc_universal = 'N';

                 if ($alterar) {
                    $loc_banco = ($lista['loc_banco'] == 'S') ? 'S' : 'N';
                 ?>
                    <input type="checkbox" name="banco" value="S" disabled
                    <?php
                       if ($loc_banco == 'S') { echo ' checked '; }
                    ?>
                    > Banco (carteira)
                    <br>
                 <?php
                    $loc_universal = ($lista['loc_universal'] == 'S') ? 'S' : 'N';
                 }
                 else {
                    echo '<input type="checkbox" name="banco" value="S"> Banco (carteira)<br>';
                 }
              ?>
              <br>
              <input type="checkbox" name="universal" value="<?php echo $loc_universal; ?>"> Local Universal
              <br><br>
              <p>
                 <button type="submit" class="btn btn-default">
                    <i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
                 <?php
                    if ($alterar) {
                       echo 'Atualizar';
                    }
                    else {
                       echo 'Gravar';
                    }
                 ?>
                 </button>

                 <?php if ($alterar) {
                    echo '<input type="hidden" name="loc_id" value="' . $loc_id . '">';
                    echo '<input type="hidden" name="loc_ativo" value="' . $lista['loc_ativo'] . '">';
                 } ?>
              </p>

           </form>

        </section>

        <?php include ('includes/rodape.php'); ?>
    </div>
    
    <?php include ('bibliotecasjs.php'); ?>
</body>
</html>