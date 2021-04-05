         <nav class="navbar navbar-default efeito-well2 mg-bottom-10">
            <div class="container-fluid">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                     <span class="sr-only">Toggle navigation</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="principal.php"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo $_SESSION['usu_nome']; ?></a>
               </div>

               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Novo<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="novo_local.php"><i class="fa fa-bank"></i>&nbsp;&nbsp;Local</a></li>
                           <li><a href="novo_endereco.php"><i class="fa fa-building"></i>&nbsp;&nbsp;Endereço</a></li>
                        </ul>
                     </li>
                  </ul>

                  <ul class="nav navbar-nav">
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cadastros<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="lista_local.php"><i class="fa fa-bank"></i>&nbsp;&nbsp;Locais</a></li>
                           <li><a href="lista_endereco.php"><i class="fa fa-building"></i>&nbsp;&nbsp;Endereços</a></li>
                        </ul>
                     </li>
                  </ul>

                  <ul class="nav navbar-nav">
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Movimentações<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="movimentacao.php?tipo=compra"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;Compra</a></li>
                           <li><a href="movimentacao.php?tipo=venda"><i class="fa fa-money"></i>&nbsp;&nbsp;Venda</a></li>
                           <li><a href="movimentacao.php?tipo=entrada"><i class="fa fa-mail-forward"></i>&nbsp;&nbsp;Entrada de Valor</a></li>
                           <li><a href="movimentacao.php?tipo=saida"><i class="fa fa-reply"></i>&nbsp;&nbsp;Saída de valor</a></li>
                           <li><a href="movimentacao.php?tipo=transferencia"><i class="fa fa-exchange"></i>&nbsp;&nbsp;Transferência</a></li>
                        </ul>
                     </li>
                  </ul>

                  <ul class="nav navbar-nav">
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Relatórios<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="relatorio.php?tipo=compra&end=nao"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;Compra</a></li>
                           <li><a href="relatorio.php?tipo=venda&end=nao"><i class="fa fa-money"></i>&nbsp;&nbsp;Venda</a></li>
                           <li><a href="relatorio.php?tipo=entrada&end=nao"><i class="fa fa-mail-forward"></i>&nbsp;&nbsp;Entrada de Valor</a></li>
                           <li><a href="relatorio.php?tipo=saida&end=nao"><i class="fa fa-reply"></i>&nbsp;&nbsp;Saída de valor</a></li>
                           <li><a href="relatorio.php?tipo=transferencia&end=nao"><i class="fa fa-exchange"></i>&nbsp;&nbsp;Transferência</a></li>
                        </ul>
                     </li>
                  </ul>

                  <ul class="nav navbar-nav">
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Configurações<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="alterar_senha.php"><i class="fa fa-key"></i>&nbsp;&nbsp;Alterar Senha</a></li>
                        </ul>
                     </li>
                  </ul>
               </div>

            </div>
         </nav>