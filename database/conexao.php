<?php
	$ip = "bd";
	$usuario = "root";
	$senha = "simsimsim";
	$banco = "jerico_bd";

	$conexao = mysqli_connect($ip, $usuario, $senha, $banco) or die("<h1>Erro ao conectar com o banco de dados.</h1>");

?>