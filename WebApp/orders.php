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

    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
    <script src="js/orders.js"></script>
</head>

<body>

<div class="container">

    <h2 class="center-middle margin-bottom"> My Orders </h2>

    <div class="table-responsive center-middle">
        <table class="table text-center" id="orders_table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Quantity</th>
					<th>State</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>


</body>

</html>