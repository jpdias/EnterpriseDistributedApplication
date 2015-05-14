<?php
session_start();

$user_check = $_SESSION["codCliente"];

if (!isset($user_check)) {
    header("Location: index.php");
} else {
    if ($user_check != $_GET["codCliente"]) {
        header("Location: index.php");
    }
}

?>