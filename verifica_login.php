<?php
   /* **
        Página que verifica o login e redireciona o operador para
        uma das páginas abaixo, de acordo com o ocorrido:

        acesso.php - Se o login for negado
        principal.php - Se estiver tudo OK
        lista_usuarios.php - Se logado como admin
        novo_endereco.php - Para cadastrar um endereço novo
                            (Redireciona para principal.php)
        escolher_endereco.php - Para escolher entre dois ou mais endereços
                                cadastrados (Redireciona para principal.php)
   ** */

   session_start();
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   // Limpar a variável de erro na seção
   if (!isset($_SESSION['msg_erro']) || $_SESSION['msg_erro'] != '') {
      $_SESSION['msg_erro'] = '';
   }

   function voltar()
   {
      $_SESSION['msg_erro'] = 'Usuário ou senha não cadastrados. ';
      header('Location: acesso.php');
      exit;
   }

   // Se tiver espaço no login, voltar...
   $valor = preg_split('//', $_POST['login']);

   if (in_array(' ', $valor)){
      voltar();
   }

   if (!isset($_POST['login']) || !isset($_POST['senha']) || $_POST['login'] == '' || $_POST['senha'] == '') {
      voltar();
   }

   $login = strip_tags(addslashes($_POST['login']));
   $senha = sha1($_POST['senha']); // Criptografa a senha

   // Checar o login e a senha
   if (!$conn = Conexao::abrir()){
      header ('Location: acesso.php');
      exit;
   }

   $comando = 'SELECT * FROM usuarios_tb WHERE usu_login = "' .
              $login . '" AND usu_senha = "' .
              $senha . '"';

   $resultado = $conn->query($comando);

   if ($resultado->rowCount() == 0){
      voltar();
   }

   // Checar a situação do usuário, se está liberado, bloqueado, etc...
   $lista = $resultado->fetch(PDO::FETCH_ASSOC);

   // Usuário bloqueado (não liberado)
   if ($lista['usu_flag'] == 'N') {
      $_SESSION['msg_erro'] = 'Usuário não liberado para acesso. <br>' .
                              'Por favor, aguarde a liberação.';
      header ('Location: acesso.php');
      exit;
   }
   
   // Usuário bloqueado pelo administrador
   if ($lista['usu_flag'] == 'B') {
      $_SESSION['msg_erro'] = 'Usuário bloqueado pelo administrador.';
      header ('Location: acesso.php');
      exit;
   }

   // Usuário administrador
   if ($lista['usu_flag'] == 'A') {
      $_SESSION['usu_logado'] = $lista['usu_id'];
      $_SESSION['usu_nome'] = $lista['usu_nome'];

      header ('Location: lista_usuarios.php');
      exit;
   }

   // Usuário comum
   if ($lista['usu_flag'] == 'S') {
      // Preencher a variável com o usuário logado
      $_SESSION['usu_logado'] = $lista['usu_id'];
      $_SESSION['usu_nome'] = $lista['usu_nome'];

      // Checar se o usuário possui um endereço cadastrado e se possui um
      // que esteja marcado como padrão
      $comando = 'SELECT * FROM enderecos_tb ' .
                 'WHERE end_usu_id = ' . $lista['usu_id'] . ' ' .
                 'AND end_ativo = "S" ' . ' ' .
                 'ORDER BY end_padrao DESC';
      $resultado = $conn->query($comando);

      // Se não tiver nenhum endereço cadastrado para aquele usuário,
      // levá-lo à tela de cadastro de endereços
      if ($resultado->rowCount() == 0) {
         $_SESSION['msg_erro'] = 'Você deve cadastrar pelo menos um endereço.';
         $_SESSION['alvo'] = 'adicionar';
         $_SESSION['pri_endereco'] = 'S';
         header ('Location: novo_endereco.php');
         exit;
      }

      if ($resultado->rowCount() > 1) {
         // Se tiver mais de um endereço para aquele usuário, terá que
         // verificar mais alguns detalhes...

         // Select para ver se há apenas um endereço padrão, ou se não
         // há, ver quantos existem cadastrados.
         // Se houver apenas um padrão, utilizar aquele
         $comando = 'SELECT * FROM enderecos_tb ' .
                    'WHERE end_usu_id = ' . $lista['usu_id'] . ' ' .
                    'AND end_ativo = "S" AND ' .
                    'end_padrao = "S"';
         $resultado = $conn->query($comando);

         if (($resultado->rowCount() == 0) || ($resultado->rowCount() > 1)) {
            // Se não existir endereço padrão ou se existir mais de um,
            // levar o operador para a página de escolha de endereço
            // a ser utilizado.

            header ('Location: escolher_endereco.php');
            exit;
         }
      }

      // Verificar se retornou apenas um endereço e utilizá-lo
      if ($resultado->rowCount() == 1) {
         $lista = $resultado->fetch(PDO::FETCH_ASSOC);

         // Preencher a variável com o id do endereço a ser utilizado
         $_SESSION['end_usu_logado'] = $lista['end_id'];
      }

      header ('Location: principal.php');
      exit;
   }

   // Usuário inativo no sistema
   if ($lista['usu_flag'] == 'I') {
      $_SESSION['msg_erro'] = 'Usuário inativo. Favor entrar com contato com ' .
                              'o administrador do sistema.';
      header ('Location: acesso.php');
      exit;
   }

?>