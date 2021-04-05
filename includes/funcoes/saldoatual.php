<?php
   function saldoAtual($usuario, $local, $conexao)
   {
      // Essa função irá retornar o saldo atual do local que for passado

         // Somar os créditos
         $comando = 'SELECT SUM(mov_valor_credito) AS "Credito" FROM movimentos_tb ' .
                    'WHERE mov_usu_id = ' . $usuario .
                    ' AND mov_local_credito = ' . $local;

         $resultado = $conexao->query($comando);
         $linha = $resultado->fetch(PDO::FETCH_BOTH);
         $credito = (float)$linha[0];

         // Somar os débitos
         $comando = 'SELECT SUM(mov_valor_debito) AS "Debito" FROM movimentos_tb ' .
                    'WHERE mov_usu_id = ' . $usuario .
                    ' AND mov_local_debito = ' . $local;

         $resultado = $conexao->query($comando);
         $linha = $resultado->fetch(PDO::FETCH_BOTH);
         $debito = (float)$linha[0];

         return (float)($credito - $debito);
   }
?>