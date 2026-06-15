<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conexao.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/util/criptografia.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/conta.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/usuario.php");

	$tabelaUsuarios = "usuario_tb";
	$tabelaContas = "conta_tb";

	$stmt_cria_usuario = mysqli_prepare($conexao, "INSERT INTO $tabelaUsuarios (id, nome, email, senha) VALUES (0, ?, ?, ?)");
	$stmt_pega_usuario = mysqli_prepare($conexao, "SELECT * FROM $tabelaUsuarios WHERE email=? LIMIT 1");
	$stmt_pega_contas = mysqli_prepare($conexao, "SELECT * FROM $tabelaContas WHERE id_usuario=?");
	$stmt_cria_conta = mysqli_prepare($conexao, "INSERT INTO $tabelaContas (id, id_usuario, plataforma, url, email_conta, login, senha, observacoes) VALUES (0, ?, ?, ?, ?, ?, ?, ?)");

	function cria_usuario($nome, $email, $senha) {
		global $conexao;
		global $stmt_cria_usuario;

		$hashSenha = hashing_senha($senha);

		mysqli_stmt_bind_param($stmt_cria_usuario, "sss", $nome, $email, $hashSenha);
		mysqli_stmt_execute($stmt_cria_usuario);
	}

	function pega_usuario($email): Usuario {
		global $conexao;
		global $stmt_pega_usuario;

		mysqli_stmt_bind_param($stmt_pega_usuario, "s", $email);
		mysqli_stmt_execute($stmt_pega_usuario);

		$resultadoMysql = mysqli_stmt_get_result($stmt_pega_usuario);
		if (!$resultadoMysql) {
			return null;
		}

		return mysqli_fetch_object($resultadoMysql, "Usuario");
	}

	function permite_acesso_conta($email, $senha): bool|null {
		$usuario = pega_usuario($email);

		if ($usuario->num_rows <= 0) {
			return null;
		}
		if (!$usuario) {
			echo "<h2>Falha ao buscar usuário com email</h2>";
			return null;
		}
		return compara_senha_e_hash($senha, $usuario->fetch_array()["senha"]);
	}

	function pega_contas($id_usuario) {
		global $conexao;
		global $stmt_pega_contas;

		mysqli_stmt_bind_param($stmt_pega_contas, "s", $id_usuario);
		mysqli_stmt_execute($stmt_pega_contas);

		return mysqli_stmt_get_result($stmt_pega_contas);
	}

	function cria_conta(Conta $conta) {
		global $conexao;
		global $stmt_cria_conta;

		mysqli_stmt_bind_param($stmt_cria_conta, "issssss", $conta->id_usuario, $conta->plataforma, $conta->url, $conta->email_conta, $conta->login, $conta->senha, $conta->observacoes);
		mysqli_stmt_execute($stmt_cria_conta);
	}


?>


