<?php

	$metodo_criptografia = "AES-256-ECB";
	
	function hashing_senha($senha): string {
		$opcoes = [
			"cost" => 13,
		];
		return password_hash($senha, PASSWORD_DEFAULT, $opcoes);
	}

	function compara_senha_e_hash($senha, $hash) {
		return password_verify($senha, $hash);
	}

	function criptografar_texto($texto, $chave) {
		global $metodo_criptografia;

		return openssl_encrypt($texto, $metodo_criptografia, $chave, 0);
	}

	function descriptografar_texto($criptografado, $chave) {
		global $metodo_criptografia;

		return openssl_decrypt($criptografado, $metodo_criptografia, $chave, 0);
	}

?>

