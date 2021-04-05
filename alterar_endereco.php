<?php
   include('verifica.php');
   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: lista_endereco.php');
      exit;
   }

   $end_id = $_POST['end_id'];
   $end_usu_id = $_POST['end_usu_id'];
   $end_descricao = strip_tags(addslashes($_POST['end_descricao']));
   $end_endereco = ($_POST['end_endereco'] == '') ? '' : strip_tags(addslashes($_POST['end_endereco'])) ;
   $end_numero = ($_POST['end_numero'] == '') ? '' : strip_tags(addslashes($_POST['end_numero'])) ;
   $end_complemento = ($_POST['end_complemento'] == '') ? '' : strip_tags(addslashes($_POST['end_complemento'])) ;
   $end_bairro = ($_POST['end_bairro'] == '') ? '' : strip_tags(addslashes($_POST['end_bairro'])) ;
   $end_cidade = ($_POST['end_cidade'] == '') ? '' : strip_tags(addslashes($_POST['end_cidade'])) ;
   $end_estado = ($_POST['end_estado'] == '') ? '' : strip_tags(addslashes($_POST['end_estado'])) ;
   $end_cep = filter_input(INPUT_POST, 'end_cep', FILTER_VALIDATE_INT);
   $end_pais = ($_POST['end_pais'] == '') ? '' : strip_tags(addslashes($_POST['end_pais'])) ;
   $end_padrao = ($_POST['end_padrao'] == '') ? '' : strip_tags(addslashes($_POST['end_padrao'])) ;
   $end_ativo = ($_POST['end_ativo'] == '') ? '' : strip_tags(addslashes($_POST['end_ativo'])) ;


   $comando = 'UPDATE enderecos_tb SET end_usu_id = "' . $end_usu_id . '", ' .
                                      'end_descricao = "' . $end_descricao . '", ' .
                                      'end_endereco = "' . $end_endereco . '", ' .
                                      'end_numero = "' . $end_numero . '", ' .
                                      'end_complemento = "' . $end_complemento . '", ' .
                                      'end_bairro = "' . $end_bairro . '", ' .
                                      'end_cidade = "' . $end_cidade . '", ' .
                                      'end_estado = "' . $end_estado . '", ' .
                                      'end_cep = "' . $end_cep . '", ' .
                                      'end_pais = "' . $end_pais . '", ' .
                                      'end_padrao = "' . $end_padrao . '", ' .
                                      'end_ativo = "' . $end_ativo . '" ' .
                                      'WHERE end_id = "' . $end_id. '"';

   $resultado = $conn->query($comando);

   if ($resultado->rowCount() > 0) {
      header ('Location: lista_endereco.php');
      exit;
   }
   else {
      $_SESSION['msg_erro'] = 'Não foi possível atualizar. <br>' . $comando;
      header ('Location: novo_endereco.php');
      exit;
   }
?>