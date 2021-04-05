<?php
   function locaisBanco($usuario, $conexao, $ativo = 'X')
      {
         // Essa função irá acumular em um array todos os locais que forem
         // banco para aquele usuário passado
         $comando = 'SELECT loc_id, loc_descricao FROM locais_tb WHERE loc_usu_id = ' . $usuario .
                    ' AND loc_banco = "S"';

         // Por padrão, irão ser filtrados todos os locais, sejam ativos ou não
         if ($ativo != 'X') {
            $comando .= ' AND loc_ativo = "' . $ativo . '"';
         }

         $resultado = $conexao->query($comando);

         $locais = array();

         while ($linha = $resultado->fetch(PDO::FETCH_BOTH)) {
            $locais[$linha[0]] = $linha[1];
         }

         return $locais;
      }
?>