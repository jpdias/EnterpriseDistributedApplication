<?php
$disc_login = true;
include "check_login.php";
?>
<!DOCTYPE html>
<html >

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../images/favicon.ico">
        <title>Keep'em</title>

        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="../css/style.css" type="text/css">

        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.js"></script>
        <script>

            $(document).ready(function () {
               $("#logout").click(function () {
                    window.location.href = "logout.php";
                });
            });
        </script>
    </head>
    <body>
        <?php include_once "nav.php"?>

        <p></p>
        <div class="container">
             <?php if ($logged) echo '<h2 class="col-sm-offset-1">Administração</h2>';
            else echo "<h2>Login de Administração</h2>" ?>
            
            <br/>
             <?php if (!$logged) {?>
            <form class="form-horizontal" action="login.php"  method="POST" role="form">
                <div class="form-group">
                    <label for="inputUsername" class="col-sm-1 control-label">Username</label>
                    <div class="col-sm-5">
                        <input name="username" type="text" class="form-control" id="username" placeholder="Username" value="<?= isset($_SESSION['u']) ? $_SESSION['u'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassowrd" class="col-sm-1 control-label">Password</label>
                    <div class="col-sm-5">
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button type="submit" class="btn btn-default">Entrar</button>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-offset-1 col-sm-10  text-danger">

                        <?php if ($error) echo $error; ?>
                    </div>
                </div>
            </form>
            <?php } else { ?>
            <div class="bs-example">
                <div class="col-sm-offset-1 col-sm-10  list-group">
                    <a href="email_form.php" class="list-group-item">
                        <h3 class="text-info list-group-item-heading"> <strong>Newsletter</strong></h3>
                        <p class="list-group-item-text ">Seccão onde pode editar e enviar email para todos os clientes subscritos à newsletter.</p>
                    </a>
                    <a href="descontos_diretos.php" class="list-group-item ">
                        <h3 class="list-group-item-heading"> <strong>Descontos Diretos</strong></h3>
                        <p class="list-group-item-text">Edite as famílias que têm desconto direto em cartão cliente em todos os produtos correspondentes.</p>
                    </a>
                    <a href="descontos_pontos.php" class="list-group-item">
                        <h3 class="list-group-item-heading"> <strong>Descontos por Pontos</strong></h3>
                        <p class="list-group-item-text">Modifique os pontos necessários para aplicar um desconto completo sobre uma compra.</p>
                    </a>
                    <a href="clientes.php" class="list-group-item">
                        <h3 class="list-group-item-heading"> <strong>Clientes</strong></h3>
                        <p class="list-group-item-text">Visualize os actuais clientes fidelizados.</p>
                    </a>
                </div>
            </div>
            <?php  } ?>
        </div>

    </body>
</html>
<?php
    unset($_SESSION['error']);
unset($_SESSION['u']);
unset($_SESSION['p']);

?>