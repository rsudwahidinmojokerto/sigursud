<?php
include "config/controller.php";
$function = new lsp();
session_start();

$auth = $function->AuthUser($_SESSION['username']);

$response = $function->sessionCheck();
if ($response == "false") {
    header("Location:index.php");
}
if (isset($_GET['logout'])) {
    $function->logout();
}
