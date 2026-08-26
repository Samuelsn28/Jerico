<?php

session_set_cookie_params(["httponly" => true]);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");

exclui_usuario($_GET["id"]);

echo "<script> window.location.href='sair.php'; </script>";

?>