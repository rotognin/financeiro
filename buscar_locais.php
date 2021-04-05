<?php
	include_once('verifica.php');

   header('Content-Type: text/html; charset=utf-8');
   require_once('includes/conexao/conexao.class.php');
   require_once('includes/funcoes/locaisbanco.php');
   require_once('includes/funcoes/saldoatual.php');
   require_once('includes/funcoes/acumulavalor.php');

   $_SESSION['msg_erro'] = '';
   if (!$conn = Conexao::abrir()) {
      header ('Location: principal.php');
      exit;
   }

   // Acumular em um array todos os locais ativos
   // $locais['2'] = 'Carteira'
   // $locais['5'] = 'Poupança 2199 Conjunta'
   $locais = locaisBanco($_SESSION['usu_logado'], $conn, 'S');
   $valores = array();

   $data_ini = '0';
   $data_fim = '0';

   if (isset($_SESSION['data_ini']) && $_SESSION['data_ini'] != '') {
      $data_ini = $_SESSION['data_ini'];
      $data_fim = $_SESSION['data_fim'];
   }

   foreach ($locais as $id_local => $descricao) {
      // $chave - Terá o loc_id
      $valores[$id_local]['local']   = $id_local;
      $valores[$id_local]['nome']    = $descricao;
      $valores[$id_local]['compra']  = (float)acumulaValor($_SESSION['usu_logado'], $id_local, $conn, 'compra', $data_ini, $data_fim);
      $valores[$id_local]['venda']   = (float)acumulaValor($_SESSION['usu_logado'], $id_local, $conn, 'venda', $data_ini, $data_fim);
      $valores[$id_local]['entrada'] = (float)acumulaValor($_SESSION['usu_logado'], $id_local, $conn, 'entrada', $data_ini, $data_fim);
      $valores[$id_local]['saida']   = (float)acumulaValor($_SESSION['usu_logado'], $id_local, $conn, 'saida', $data_ini, $data_fim);
      $valores[$id_local]['transferencia_ent'] = (float)acumulaValor($_SESSION['usu_logado'], $id_local, $conn, 'transferencia_ent', $data_ini, $data_fim);
      $valores[$id_local]['transferencia_sai'] = (float)acumulaValor($_SESSION['usu_logado'], $id_local, $conn, 'transferencia_sai', $data_ini, $data_fim);
      $valores[$id_local]['saldo']   = (float)saldoAtual($_SESSION['usu_logado'], $id_local, $conn);
   }

   // Continuar
   $conteudo = '';

   foreach ($valores as $local => $valor) {
      if ($valor['saldo'] >= 0) {
         $classe_saldo = 'valor_positivo';
      } else {
         $classe_saldo = 'valor_negativo';
      }

      $conteudo .= '<div class="bancos">' .
                      '<div class="hidden-xs">' .
                         '<div class="mov_local_in">' .
                             '<div class="mov_val_local_in">' . $valor['nome'] . '</div>' .
                         '</div>' .
                         '<div class="mov_compra_in hidden-xs">' .
                            '<a class="destacar" href="javascript:;"><div data-debcre="deb" data-local="' . $valor['local'] . '" data-tipo="compra" data-toggle="modal" data-target="#myModal" class="mov_val_compra_in valor_negativo">R$ ' . $valor['compra'] . '</div></a>' .
                         '</div>' .
                         '<div class="mov_venda_in hidden-xs">' .
                             '<a class="destacar" href="javascript:;"><div data-debcre="cre" data-local="' . $valor['local'] . '" data-tipo="venda" data-toggle="modal" data-target="#myModal" class="mov_val_venda_in valor_positivo">R$ ' . $valor['venda'] . '</div></a>' .
                         '</div>' .
                         '<div class="mov_entrada_in hidden-xs">' .
                             '<a class="destacar" href="javascript:;"><div data-debcre="cre" data-local="' . $valor['local'] . '" data-tipo="entrada" data-toggle="modal" data-target="#myModal" class="mov_val_entrada_in valor_positivo">R$ ' . $valor['entrada'] . '</div></a>' .
                         '</div>' .
                         '<div class="mov_saida_in hidden-xs">' .
                             '<a class="destacar" href="javascript:;"><div data-debcre="deb" data-local="' . $valor['local'] . '" data-tipo="saida" data-toggle="modal" data-target="#myModal" class="mov_val_saida_in valor_negativo">R$ ' . $valor['saida'] . '</div></a>' .
                         '</div>' .
                         '<div class="mov_transferencia_in hidden-xs">' .
                             '<div class="mov_val_transferencia_in">' .
                                '<a class="destacar" href="javascript:;"><div data-debcre="cre" data-local="' . $valor['local'] . '" data-tipo="transferenciaent" data-toggle="modal" data-target="#myModal" class="mov_val_entrada_transferencia_in valor_positivo">R$ ' . $valor['transferencia_ent'] . '</div></a>' .
                                '<a class="destacar" href="javascript:;"><div data-debcre="deb" data-local="' . $valor['local'] . '" data-tipo="transferenciasai" data-toggle="modal" data-target="#myModal" class="mov_val_saida_transferencia_in valor_negativo">R$ ' . $valor['transferencia_sai'] . '</div></a>' .
                             '</div>' .
                         '</div>' .
                         '<div class="mov_saldo_in">' .
                             '<a class="destacar" href="javascript:;"><div data-debcre="sal" data-local="' . $valor['local'] . '" data-tipo="saldo" data-toggle="modal" data-target="#myModal" class="mov_val_saldo_in ' . $classe_saldo . '"><strong>R$ ' . $valor['saldo'] . '</strong></div></a>' .
                         '</div>' .
                      '</div>' .
                      '<div class="visible-xs-block dados-xs">' .
                         '<div class="mov_local_in_xs destacar" data-codigo="' . $valor['local'] . '">' .
                             '<div class="mov_val_local_in_xs">' . $valor['nome'] . '&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></div>' .
                         '</div>' .
                         '<div class="mov_saldo_in_xs">' .
                             '<a class="destacar" href="javascript:;"><div data-debcre="sal" data-local="' . $valor['local'] . '" data-tipo="saldo" data-toggle="modal" data-target="#myModal" class="mov_val_saldo_in_xs ' . $classe_saldo . '"><strong>R$ ' . $valor['saldo'] . '</strong></div></a>' .
                         '</div>' .
                         '<ul class="sem-lista escondido" id="' . $valor['local'] . '">' .
                            '<a class="destacar" href="javascript:;"><li class="zebra1" data-debcre="deb" data-local="' . $valor['local'] . '" data-tipo="compra" data-toggle="modal" data-target="#myModal">Compras &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="valor_negativo">R$ - ' . $valor['compra'] . '</span></li></a>' .
                            '<a class="destacar" href="javascript:;"><li class="zebra2" data-debcre="cre" data-local="' . $valor['local'] . '" data-tipo="venda" data-toggle="modal" data-target="#myModal">Vendas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="valor_positivo">R$ ' . $valor['venda'] . '</span></li></a>' .
                            '<a class="destacar" href="javascript:;"><li class="zebra1" data-debcre="cre" data-local="' . $valor['local'] . '" data-tipo="entrada" data-toggle="modal" data-target="#myModal">Entradas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="valor_positivo">R$ ' . $valor['entrada'] . '</span></li></a>' .
                            '<a class="destacar" href="javascript:;"><li class="zebra2" data-debcre="deb" data-local="' . $valor['local'] . '" data-tipo="saida" data-toggle="modal" data-target="#myModal">Saídas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="valor_negativo">R$ - ' . $valor['saida'] . '</span></li></a>' .
                            '<a class="destacar" href="javascript:;"><li class="zebra1" data-debcre="cre" data-local="' . $valor['local'] . '" data-tipo="transferenciaent" data-toggle="modal" data-target="#myModal">Transf. entrada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="valor_positivo">R$ ' . $valor['transferencia_ent'] . '</span></li></a>' .
                            '<a class="destacar" href="javascript:;"><li class="zebra2" data-debcre="deb" data-local="' . $valor['local'] . '" data-tipo="transferenciasai" data-toggle="modal" data-target="#myModal">Transf. saída &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="valor_negativo">R$ - ' . $valor['transferencia_sai'] . '</span></li></a>' .
                         '</ul>' .
                      '</div>' .
                      '<div id="clear_float"></div>' .
                   '</div>';
   }

   echo $conteudo;
?>