<?php
	
	function hashing_senha($senha): string {
		$opcoes = [
			"cost" => 13,
		];
		return password_hash($senha, PASSWORD_DEFAULT, $opcoes);
	}

	function compara_senha_e_hash($senha, $hash) {
		return password_verify($senha, $hash);
	}

?>

