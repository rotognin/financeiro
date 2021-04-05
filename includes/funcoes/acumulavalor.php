<?php
   /*
      Função que irá acumular o total para um local para um determinado tipo
         de movimentação.
      O filtro poderá ser por período também, mas será opcional.
   */

   function acumulaValor($usuario, $local, $conexao, $tipo, $data_ini = '0', $data_fim = '0')
   {
         if ($tipo == 'compra' || $tipo == 'saida' || $tipo == 'transferencia_sai') {
            $campo = 'mov_local_debito';
            $campo_valor = 'mov_valor_debito';
         } else {
            $campo = 'mov_local_credito';
            $campo_valor = 'mov_valor_credito';
         }
         
         if ($tipo == 'transferencia_sai' || $tipo == 'transferencia_ent') {
            $tipo = 'transferencia';
         }

         if ($data_ini != '0' && $data_fim != '0') {
            $filtra_data_ini = $data_ini . ' 00:00:00';
            $filtra_data_fim = $data_fim . ' 23:59:59';
         }
         
         /* - Comando completo de exemplo para acumular valores
            SELECT SUM(mov_valor_debito) as 'Soma' FROM `movimentos_tb` 
            WHERE mov_usu_id = 1 AND 
                  mov_local_debito = 5 AND 
                  mov_tipo = 'saida' AND
                  mov_data_hora BETWEEN "2015-05-05 00:00:00" AND "2015-05-06 23:59:59"
         */
         
         $comando = 'SELECT SUM(' . $campo_valor . ') AS "Soma" FROM movimentos_tb ' .
                    'WHERE mov_usu_id = ' . $usuario .
                    ' AND mov_tipo = "' . $tipo .
                    '" AND ' . $campo . ' = ' . $local;
                    
         // echo $comando . "<br><br>";
                    
         // Concatenar o filtro por data
         if ($data_ini > 0 && $data_fim > 0) {
            $comando .= ' AND mov_data_hora BETWEEN "' . $filtra_data_ini .
                        '" AND "' . $filtra_data_fim . '"';
         }
         
         $resultado = $conexao->query($comando);
         $linha = $resultado->fetch(PDO::FETCH_BOTH);
         $valor = (float)$linha[0];
         return $valor;
   }
?>