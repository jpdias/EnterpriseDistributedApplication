<?php include("navbar.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Enterprise Distributed Application</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link href="signin.css" rel="stylesheet"> -->

    <script src="js/jquery.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
    <script src="js/catalog.js"></script>
</head>

<body>

<div class="container">

    <h2 class="center-middle margin-bottom"> Catalog </h2>

	<div align="right">Order quantity: <input type="number" id="quantity" name="quantity" min="1" max="10" value="1"></div>
	
    <div class="table-responsive center-middle">
        <table class="table text-center" id="catalog_table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Editor</th>
					<th>Price</th>
					<th>Stock</th>
					<th>Order</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

</body>

</html>