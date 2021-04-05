<?php
	include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: principal.php');
      exit;
   }

   $tipomov = $_GET['tipomov']; // Crédito, Débito ou Saldo
   $local = $_GET['local'];     // Código do local de movimentação (banco)
   $mov = $_GET['mov'];         // Tipo do movimento

   if ($tipomov == 'deb') {
      $mov_local = 'mov_local_debito';
      $mov_valor = 'mov_valor_debito';
   } elseif ($tipomov == 'cre') {
      $mov_local = 'mov_local_credito';
      $mov_valor = 'mov_valor_credito';
   } else {
      $mov_local = 'saldo';
      $mov_valor = 'saldo';
   }

   $tipos = array('compra'           => 'Compras',
                  'venda'            => 'Vendas',
                  'entrada'          => 'Entradas de Valor',
                  'saida'            => 'Saídas de Valor',
                  'transferenciaent' => 'Transferências para Dentro',
                  'transferenciasai' => 'Transferências para Fora',
                  'saldo'            => 'Saldo');

   $movimento = '<p><strong>' . $tipos[$mov] . '</strong></p>';

   $movimento .= '<div id="cabecalho_det" class="hidden-xs">' .
                    '<div class="cabecalho_det_descricao">Descrição</div>' .
                    '<div class="cabecalho_det_data">Data / Hora</div>' .
                    '<div class="cabecalho_det_valor">Valor</div>' .
                    '<div id="clear_float"></div>'.
                 '</div>' .
                 '<div id="cabecalho_det_xs" class="visible-xs-block">' .
                    '<div class="cabecalho_det_descricao_xs">Descrição</div>' .
                    '<div class="cabecalho_det_data_xs">Data / Hora</div>' .
                    '<div class="cabecalho_det_valor_xs">Valor</div>' .
                    '<div id="clear_float"></div>'.
                 '</div>' .
                 '<hr class="menos_margem">';

   if ($mov == 'transferenciaent' || $mov == 'transferenciasai') {
      $mov = 'transferencia';
   }

   // Irá ser montado um SELECT quando o tipo de movimento for
   // crédito ou débito, e outro para quando for saldo.
   if ($mov_local != 'saldo') {
      $comando = 'SELECT * FROM movimentos_tb ' .
                 'WHERE mov_usu_id = ' . $_SESSION['usu_logado'] .
                 ' AND ' . $mov_local . ' = ' . $local .
                 ' AND mov_tipo = "' . $mov . '"' .
                 ' ORDER BY mov_id DESC';
   } else {
      // Se for saldo, irá buscar todos os registros
      $comando = 'SELECT * FROM movimentos_tb ' .
                 'WHERE mov_usu_id = ' . $_SESSION['usu_logado'] .
                 ' AND (mov_local_credito = ' . $local . ' OR ' .
                       'mov_local_debito = ' . $local . ')' .
                 ' ORDER BY mov_id DESC';
   }

   $resultado = $conn->query($comando);
   $indic = '  ';

   if ($resultado->rowCount() > 0) {
      foreach ($resultado as $linha) {
         $data_hora = explode(' ', $linha['mov_data_hora']);
         $data_array = explode('-', $data_hora[0]);
         $hora_array = explode(':', $data_hora[1]);

         $data_hora_real = $data_array[2] . '/' .
                           $data_array[1] . '/' .
                           $data_array[0] . ' ' .
                           $hora_array[0] . 'h' .
                           $hora_array[1];

         if ($mov_local == 'saldo') {
            if ($linha['mov_tipo'] == 'compra' || $linha['mov_tipo'] == 'saida') {
               $mov_valor = 'mov_valor_debito';
               $indic = '- ';
            } else {
               $mov_valor = 'mov_valor_credito';
               $indic = '  ';
            }
         }

         $movimento .= '<div id="movimento_det" class="impar hidden-xs">' .
                          '<div class="movimento_det_descricao">' . $linha['mov_descricao'] . '</div>' .
                          '<div class="movimento_det_data">' . $data_hora_real . '</div>' .
                          '<div class="movimento_det_valor">R$ ' . $indic . $linha[$mov_valor] . '</div>' .
                          '<div id="clear_float"></div>' .
                       '</div>' .
                       '<div id="movimento_det_xs" class="visible-xs-block">' .
                          '<div class="movimento_det_descricao_xs"><strong>' . $linha['mov_descricao'] . '</strong></div>' .
                          '<div class="movimento_det_data_xs">' . $data_hora_real . '</div>' .
                          '<div class="movimento_det_valor_xs">R$ ' . $indic . $linha[$mov_valor] . '</div>' .
                          '<div id="clear_float"></div>' .
                       '</div>';

      }
   } else {
      $movimento .= '<p>Sem movimentos</p>';
   }

   echo $movimento;

?>