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

        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/register.js"></script>
    </head>

    <body>

        <div class="container">

            <div class="page-header">
                <h1>Enterprise Distributed Application <small>New Customer</small></h1>
            </div>

            <form id="formNewCostumer" class="form-signin form-horizontal" role="form">
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="Name" id="inputName" class="form-control" placeholder="Name">
                    </div>
                </div>

                <div class="form-group">

                    <label for="inputEmail" class="col-sm-2 control-label">E-Mail</label>
                    <div class="col-sm-10">

                        <input type="email" name="Email" id="inputEmail" class="form-control" placeholder="E-mail">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="Password" id="inputPassword" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class=" col-sm-10 col-sm-offset-2" style="padding:0px">
                    <button type="submit" id="newCostumerButton" class="btn btn-lg btn-default btn-block">Register</button>
                </div>

            </form>

        </div>
    </body>

</html>
