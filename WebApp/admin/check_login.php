<?php
session_start();
$logged = isset($_SESSION['username']);
if (isset($_SESSION['error']))
    $error = $_SESSION['error'];
else
    $error = false;

if (!$logged && !isset($disc_login)) {
    $_SESSION['error'] = "Inicie sessão para aceder às funcionalidades de administrador";
    $error = true;
    header("location: index.php");
}
?>