<?php
   session_start();
   header('Content-Type: text/html; charset=utf-8');

   $_SESSION['msg_erro'] = '';
   require_once('includes/conexao/conexao.class.php');

   function protegerVars($variavel)
   {
      return strip_tags(addslashes($variavel));
   }

   function preencheSession($variavel)
   {
      $_SESSION['usu_nome'] = $variavel['nome']['valor'];
      $_SESSION['usu_login'] = $variavel['login']['valor'];
      $_SESSION['usu_email'] = $variavel['email']['valor'];
   }

   function checaCampo($valor, $minimo, $maximo)
   {
      $num = strlen($valor);
      if (($num < $minimo) || ($num > $maximo)) {
         return false;
      }

      return true;
   }
   
   // Checar se contém espaços no login
   if (in_array(' ', preg_split('//', $_POST['login']))){
      preencheSession($infos);
      $_SESSION['msg_erro'] = 'Não pode haver espaço no login.';
      header ('Location: novo_cadastro.php');
      exit;
   }
   
   $infos = array();

   $infos['nome']['valor'] = protegerVars($_POST['nome']);
   $infos['login']['valor'] = protegerVars($_POST['login']);
   $infos['senha']['valor'] = protegerVars($_POST['senha']);
   $infos['senha2']['valor'] = protegerVars($_POST['senha2']);
   $infos['email']['valor'] = protegerVars($_POST['email']);

   $infos['nome']['min'] = 8;
   $infos['nome']['max'] = 80;
   $infos['login']['min'] = 8;
   $infos['login']['max'] = 20;
   $infos['senha']['min'] = 5;
   $infos['senha']['max'] = 20;
   $infos['email']['min'] = 8;
   $infos['email']['max'] = 80;

   // Checar se as senhas são iguais
   if ($infos['senha']['valor'] != $infos['senha2']['valor']) {
      preencheSession($infos);
      $_SESSION['msg_erro'] = 'As senhas devem ser iguais!';
      header ('Location: novo_cadastro.php');
      exit;
   }

   // Verificar se a quantidade de caracteres batem para cada campo
   $campo = array('nome', 'login', 'senha', 'email');

   foreach ($campo as $valor) {
      if (!checaCampo($infos[$valor]['valor'], $infos[$valor]['min'], $infos[$valor]['max'])) {
         preencheSession($infos);
         $_SESSION['msg_erro'] = 'O campo ' . $valor . ' deve conter entre ' .
                                 $infos[$valor]['min'] . ' e ' .
                                 $infos[$valor]['max'] . ' caracteres.';
         header ('Location: novo_cadastro.php');
         exit;
      }
   }

    // Transforma a senha com criptografia
   $infos['senha']['valor'] = sha1($infos['senha']['valor']);

   // Verificação inicial no banco: ver se aquele login já existe, ou se já
   // existe um e-mail igual já cadastrado
   if (!$conn = Conexao::abrir()) {
      preencheSession($infos);
      header ('Location: novo_cadastro.php');
      exit;
   }

   // Checar se o login ou o e-mail já existe
   $comando = 'SELECT * FROM usuarios_tb ' .
              'WHERE usu_login = "' . $infos['login']['valor'] . '" OR ' .
              'usu_email = "' . $infos['email']['valor'] . '"';
   $resultado = $conn->query($comando);

   if ($resultado->rowCount() > 0) {
      preencheSession($infos);
      $_SESSION['msg_erro'] = 'Login ou E-mail já cadastrados no sistema.';
      header ('Location: novo_cadastro.php');
      exit;
   }

   // Após isso, poderá inserir o cadastro no banco e exibir uma página em HTML
   // abaixo do PHP aqui mesmo informando que o usuário receberá um aviso
   // por e-mail para poder acessar o sistema

   $comando = 'INSERT INTO usuarios_tb (usu_nome, usu_login, usu_senha, usu_email, usu_flag) ' .
              'VALUES ("' .
              $infos['nome']['valor'] . '", "' .
              $infos['login']['valor'] . '", "' .
              $infos['senha']['valor'] . '", "' .
              $infos['email']['valor'] . '", "N")';
   $resultado = $conn->query($comando);

   if ($resultado->rowCount() == 0) {
      preencheSession($infos);

      $msg_erro = 'Erro ao inserir novo usuário: ';
      foreach ($resultado->errorInfo() as $valor) {
         $msg_erro .= $valor . ' ';
      }

      $_SESSION['msg_erro'] = $msg_erro;
      header ('Location: novo_cadastro.php');
      exit;
   }
?>

<!doctype html>
<html>
<?php include_once('includes/head_padrao.php'); ?>

<body>
	<div id="principal" class="container-fluid">
      <?php include ('includes/cabecalho.php'); ?>

      <section id="conteudo">
         <br>
         <p>Cadastro efetuado com sucesso. Aguarde um e-mail de confirmação para
            acessar e começar a utilizar o controle financeiro.</p>
         <p><a href="index.php">Clique aqui para voltar à página inicial.</a></p>
      </section>

      <?php include ('includes/rodape.php'); ?>
   </div>
</body>
</html>