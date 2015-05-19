<?php
session_start();

$user_check = $_SESSION["id"];

if (!isset($user_check)) {
    header("Location: index.php");
} else {
    if ($user_check != $_GET["id"]) {
        header("Location: index.php");
    }
}

?>