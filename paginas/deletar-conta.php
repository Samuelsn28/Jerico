<?php

session_set_cookie_params(["httponly" => true]);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header("location: ../login.php");
    exit();
}


if (isset($_GET["id"])) {
	$resultado = deleta_conta($_GET["id"]);

	if ($resultado < 0) {
		echo "<script> alert('Um erro ocorreu. Não foi possível deletar a conta.'); </script>";
	} else {
		echo "<script> alert('Conta deletada com sucesso.'); </script>";
	}

	echo "<script> window.location.href='senhassalvas.php'; </script>";
	exit();
}



?>

