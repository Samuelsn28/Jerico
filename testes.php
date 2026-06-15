<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/usuario.php");

	$retorno = pega_usuario("email@gmail");

	echo var_dump($retorno);

?>