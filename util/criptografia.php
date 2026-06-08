<?php
	
	function hashing_senha($string): string {
		$opcoes = [
			"cost" => 13,
		];
		return password_hash($string, PASSWORD_DEFAULT, $opcoes);
	}

?>

