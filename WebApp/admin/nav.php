<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
            <a class="navbar-brand" href="index.php">Keep'em Administração</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li style="text-align:center"><a href="email_form.php">Newsletter</a></li>
                <li class="dropdown" style="text-align:center">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gestão de descontos <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li style="text-align:center"><a href="descontos_diretos.php">Descontos Directos (Famílias)</a>
                        </li>
                        <li style="text-align:center"><a href="descontos_pontos.php">Descontos Por Pontos</a>
                        </li>
                    </ul>
                </li>
                <li style="text-align:center"><a href="clientes.php">Clientes Fidelizados</a></li>	
            </ul>
			<ul>
				<li style="text-align:center"><?php if ($logged) { ?>
				<button type="button" id="logout" class="btn btn-default navbar-btn navbar-right" style="text-align:center">Log out</button>
					<?php } ?>
				</li>
			</ul>
            
		</div>
                <!-- /.navbar-collapse -->
	</div>
            <!-- /.container-fluid -->
            </nav>