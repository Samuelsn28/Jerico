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
	$stmt_pega_conta_especifica = mysqli_prepare($conexao, "SELECT * FROM $tabelaContas WHERE id_usuario=? AND id=?");
	$stmt_cria_conta = mysqli_prepare($conexao, "INSERT INTO $tabelaContas (id, id_usuario, plataforma, url, email_conta, login, senha, observacoes) VALUES (0, ?, ?, ?, ?, ?, ?, ?)");
	$stmt_atualiza_conta = mysqli_prepare($conexao, "UPDATE $tabelaContas SET plataforma=?, url=?, email_conta=?, login=?, senha=?, observacoes=? WHERE id=?");
	$stmt_deleta_conta = mysqli_prepare($conexao, "DELETE FROM $tabelaContas WHERE id=?");

	function cria_usuario($nome, $email, $senha) 
{		global $conexao;
		global $stmt_cria_usuario;

		$hashSenha = hashing_senha($senha);

		mysqli_stmt_bind_param($stmt_cria_usuario, "sss", $nome, $email, $hashSenha);
		mysqli_stmt_execute($stmt_cria_usuario);
	}

	function pega_usuario($email): ?Usuario {
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

		if ($usuario == null) {
			return null;
		}
		return compara_senha_e_hash($senha, $usuario->senha);
	}

	function pega_contas($id_usuario) {
		global $conexao;
		global $stmt_pega_contas;

		mysqli_stmt_bind_param($stmt_pega_contas, "i", $id_usuario);
		mysqli_stmt_execute($stmt_pega_contas);

		$contas = [];
		$resultado = mysqli_stmt_get_result($stmt_pega_contas);

		while ($conta = mysqli_fetch_object($resultado, "Conta")) {
			$contas[] = $conta; 
		}
		return $contas;
	}

	function pega_conta_especifica($id_usuario, $id_conta): Conta {
		global $conexao;
		global $stmt_pega_conta_especifica;

		mysqli_stmt_bind_param($stmt_pega_conta_especifica, "ii", $id_usuario, $id_conta);
		mysqli_stmt_execute($stmt_pega_conta_especifica);

		$resultado = mysqli_stmt_get_result($stmt_pega_conta_especifica);
		return mysqli_fetch_object($resultado, "Conta");
	}

	function cria_conta(Conta $conta) {
		global $conexao;
		global $stmt_cria_conta;

		mysqli_stmt_bind_param($stmt_cria_conta, "issssss", $conta->id_usuario, $conta->plataforma, $conta->url, $conta->email_conta, $conta->login, $conta->senha, $conta->observacoes);
		mysqli_stmt_execute($stmt_cria_conta);
	}

	function atualiza_conta($id_conta, Conta $contaAtualizada): int {
		global $conexao;
		global $stmt_atualiza_conta;

		mysqli_stmt_bind_param($stmt_atualiza_conta, "ssssssi", $contaAtualizada->plataforma, $contaAtualizada->url, $contaAtualizada->email_conta, $contaAtualizada->login, $contaAtualizada->senha, $contaAtualizada->observacoes, $id_conta);
		mysqli_stmt_execute($stmt_atualiza_conta);

		return mysqli_affected_rows($conexao);
	}

	function deleta_conta($id_conta): int {
		global $conexao;
		global $stmt_deleta_conta;

		mysqli_stmt_bind_param($stmt_deleta_conta, "i", $id_conta);
		mysqli_stmt_execute($stmt_deleta_conta);

		return mysqli_affected_rows($conexao);
	}


?>


