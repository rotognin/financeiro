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

   $mov_local = 'saldo';
   $mov_valor = 'saldo';

   $tipos = array('compra'           => 'Compras',
                  'venda'            => 'Vendas',
                  'entrada'          => 'Entradas de Valor',
                  'saida'            => 'Saídas de Valor',
                  'transferenciaent' => 'Transferências para Dentro',
                  'transferenciasai' => 'Transferências para Fora',
                  'saldo'            => 'Saldo');

   $movimento = '<p><strong>Saldo</strong></p>';

   if ($tipos[$mov] == 'Saldo')
   {
      // Controle de exibição mensal
      $mes_atual = (int)date("m");
      $ano_atual = (int)date("Y");
      $ano_escrever = 2015;

      $array_mes = array("", "", "", "", "", "", "", "", "", "", "", "", "");
      $array_mes[$mes_atual] = 'selected';

      $movimento .= ' - Data: ';
      $movimento .= '<select id="mes_pesquisa">' .
                       '<option value="01" ' . $array_mes[01] . '>Janeiro</option>' .
                       '<option value="02" ' . $array_mes[02] . '>Fevereiro</option>' .
                       '<option value="03" ' . $array_mes[03] . '>Março</option>' .
                       '<option value="04" ' . $array_mes[04] . '>Abril</option>' .
                       '<option value="05" ' . $array_mes[05] . '>Maio</option>' .
                       '<option value="06" ' . $array_mes[06] . '>Junho</option>' .
                       '<option value="07" ' . $array_mes[07] . '>Julho</option>' .
                       '<option value="08" ' . $array_mes[08] . '>Agosto</option>' .
                       '<option value="09" ' . $array_mes[09] . '>Setembro</option>' .
                       '<option value="10" ' . $array_mes[10] . '>Outubro</option>' .
                       '<option value="11" ' . $array_mes[11] . '>Novembro</option>' .
                       '<option value="12" ' . $array_mes[12] . '>Dezembro</option>' .
                    '</select> - ';

      $movimento .= '<select id="ano_pesquisa">';

      while ($ano_escrever <= $ano_atual)
      {
         if ($ano_escrever == $ano_atual) {
            $movimento .= '<option value"' . $ano_escrever . '" selected>' . $ano_escrever . '</option>';
         }
         else {
            $movimento .= '<option value"' . $ano_escrever . '">' . $ano_escrever . '</option>';
         }

         $ano_escrever++;
      }

      $movimento .= '</select>&nbsp;&nbsp;';
      $movimento .= '<button type="button" id="repesquisa"><i class="fa fa-search"></i></button><br><br>';
   }

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

   $data_ini = (string)$_GET['pano'] . '-' . (string)$_GET['pmes'] . '-01 00:00:00';
   $data_fim = (string)$_GET['pano'] . '-' . (string)$_GET['pmes'] . '-31 23:59:59';

   // Se for saldo, irá buscar todos os registros
   $comando = 'SELECT * FROM movimentos_tb ' .
              'WHERE mov_usu_id = ' . $_SESSION['usu_logado'] .
              ' AND (mov_local_credito = ' . $local . ' OR ' .
                    'mov_local_debito = ' . $local . ') AND ' .
              'mov_data_hora BETWEEN "' . $data_ini . '" AND "' . $data_fim . '"' .
              ' ORDER BY mov_id DESC';

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