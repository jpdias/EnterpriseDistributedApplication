<?php include( "session.php"); ?>

<html>

<head>

    <!-- Bootstrap -->
    <!-- <link href="../css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- <script type="text/javascript" src="../js/bootstrap.min.js"></script> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/dataTables.bootstrap.css">

    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Enterprise Distributed Application</title>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
	<script src="/js/navbar.js"></script>
</head>

<body>
    <nav class="navbar navbar-default" role="navigation">
	
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                <a class="navbar-brand">Enterprise Distributed Application</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li style="text-align:center"><a href="profile.php?codCliente=<?php echo $_SESSION['codCliente'];?>">My Profile</a>
                    <li style="text-align:center"><a href="catalog.php?codCliente=<?php echo $_SESSION['codCliente'];?>">Catalog</a>
					<li style="text-align:center"><a href="history.php?codCliente=<?php echo $_SESSION['codCliente'];?>">History</a>
                    </li>
                </ul>
				<ul class="nav navbar-nav navbar-right">
					Hello, <a href="profile.php?codCliente=<?php echo $_SESSION['codCliente'];?>"><?php echo $_SESSION['nomeCliente'];?></a>!
					<a href="logout.php"><button type="button" id="logout" class="btn btn-default btn-xs navbar-btn">Log Out</button></a>
				</ul>
				
                <!-- <button type="button" id="logout" class="btn btn-default navbar-btn navbar-right">Log out</button </div> -->
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
    </nav>
