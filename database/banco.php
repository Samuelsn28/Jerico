<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conexao.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/util/criptografia.php");

	$tabelaUsuarios = "usuario_tb";

	$stmt_cria_usuario = mysqli_prepare($conexao, "INSERT INTO $tabelaUsuarios (id, nome, email, senha) VALUES (0, ?, ?, ?)");

	function cria_usuario($nome, $email, $senha) {
		global $conexao;
		global $stmt_cria_usuario;

		$hashSenha = hashing_senha($senha);

		mysqli_stmt_bind_param($stmt_cria_usuario, "sss", $nome, $email, $hashSenha);
		mysqli_stmt_execute($stmt_cria_usuario);
	}


?>


