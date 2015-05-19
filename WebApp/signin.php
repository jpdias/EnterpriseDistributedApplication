<?php include("login.php"); ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="images/favicon.ico">
        <title>Enterprise Distributed Application</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <!-- <link href="signin.css" rel="stylesheet"> -->

        <script src="js/jquery.min.js"></script>
    </head>

    <body>

        <div class="container">
            <div class="page-header">
                <h1>Enterprise Distributed Application <small>Sign In</small></h1>
            </div>
            <form class="form-signin form-horizontal" role="form" action="" method="post">
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-1 control-label">Email</label>
                    <div class="col-sm-11">
                        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-1 control-label">Password</label>
                    <div class="col-sm-11">
                        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <div class="col-sm-11 col-sm-offset-1" style="padding:0px">
                    <button class="btn btn-lg btn-default btn-block" name="submit" type="submit">Sign In</button>
                </div>
            </form>
        </div>
    </body>

</html>
