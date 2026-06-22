<?php

session_set_cookie_params(["httponly" => true]);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$conta = pega_conta_especifica($_SESSION["id_usuario"], ((int) $_GET["id"]));

?>

<!DOCTYPE html>
<html lang="pt-BR">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Edição - Jericó</title>
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
	    <link rel="stylesheet" href="./css/padrao.css">
	    <link rel="stylesheet" href="./css/pagina-principal.css">
	    <style>
	    	body {
	    		display: flex;
	    		justify-content: center;
	    		align-items: center;
	    	}

	    	h2 {
	    		color: #A5B4FC;
	    	}

	    	hr {
	    		border: 1px solid #A5B4FC;
	    	}

	    	#editar-form {
	    		width: 50vw;
	    		padding: 30px 0;
	    		display: flex;
	    		flex-direction: column;
	    		gap: 10px;
	    	}

	    	#espacamento {
	    		height: 20px;
	    		color: transparent;
	    	}

		    .field {
	            margin-bottom: 1.4rem;
	        }

	        .field-label {
	            font-size: 0.9rem;
	            color: #A5B4FC;
	            margin-bottom: 8px;
	        }

	        .field-value {
	            background: rgba(30, 20, 70, 0.9);
	            padding: 14px 16px;
	            border-radius: 10px;
	            font-family: monospace;
	            color: #E0E7FF;
	            border: 1px solid rgba(155, 122, 234, 0.25);
	            word-break: break-all;
	        }

	        .mostrar {
	            background: #0e3573;
	            color: white;
	            border: none;
	            padding: 10px 16px;
	            border-radius: 8px;
	            cursor: pointer;
	            font-size: 0.95rem;
	        }

	        .btn {
	            flex: 1;
	            padding: 13px;
	            border: none;
	            border-radius: 10px;
	            cursor: pointer;
	        }

	        .btn-edit {
	        	background: #3026EE; color: white; 
	        }

	        .btn-cancelar {
	        	background: rgb(136, 5, 31); color: white; 
	        }
	    </style>
	</head>
	<body>

		<form id="editar-form" method="POST" action="#">
			<h2>Edição de conta</h2>
			<hr>

			<label class="field-label" for="plataforma-input">Plataforma</label>
			<input class="field-value" type="text" name="plataforma-input" id="plataforma-input" value="<?= $conta->plataforma ?>" required>

			<label class="field-label" for="url-input">URL</label>
			<input class="field-value" type="text" name="url-input" id="url-input" value="<?= $conta->url ?>">

			<label class="field-label" for="email-conta-input">E-mail da conta</label>
			<input class="field-value" type="text" name="email-conta-input" id="email-conta-input" value="<?= $conta->email_conta ?>">

			<label class="field-label" for="login-input">Login</label>
			<input class="field-value" type="text" name="login-input" id="login-input" value="<?= $conta->login ?>">

			<label class="field-label" for="senha-input">Senha</label>

			<section style="display: flex">
				<input class="field-value" type="password" name="senha-input" id="senha-input" value="<?= $conta->senha ?>" style="flex: 1; margin-right: 30px" required="">
				<button type="button" class="mostrar" onclick="toggleSenha('<?= htmlspecialchars(addslashes($conta->senha ?? '')) ?>')">
					Mostrar
				</button>
			</section>

			<label class="field-label" for="observacoes-input">Observações</label>
			<textarea class="field-value" name="observacoes-input" id="observacoes-input"><?= $conta->observacoes ?></textarea>

			<section id="espacamento"></section>

			<input type="submit" class="btn btn-edit" name="edicao" value="Confirmar">
			<button class="btn btn-cancelar" type="button" onclick="location.href='senhassalvas.php'">Cancelar</button>
		</form>

	<script>
        function toggleSenha(senhaReal) {
            const campo = document.getElementById('senha-input');
            const botao = campo.parentElement.querySelector('button');

            if (campo.type === 'password') {
                campo.type = 'text';
                botao.textContent = 'Ocultar';
            } else {
                campo.type = 'password';
                botao.textContent = 'Mostrar';
            }
        }
    </script>
	</body>
</html>
<?php

	if (isset($_POST["edicao"])) {
		$plataforma = $_POST["plataforma-input"];
		$url = $_POST["url-input"];
		$email_conta = $_POST["email-conta-input"];
		$senha = $_POST["senha-input"];
		$login = $_POST["login-input"];
		$observacoes = $_POST["observacoes-input"];

		if (trim($plataforma) == "") {
			echo "<script> alert('O campo plataforma não pode ser vazio.'); </script>";
			exit();
		}
		if (trim($senha) == "") {
			echo "<script> alert('O campo senha não pode ser vazio.'); </script>";
			exit();
		}

		$conta->plataforma = $plataforma;
		$conta->url = $url;
		$conta->email_conta = $email_conta;
		$conta->senha = $senha;
		$conta->login = $login;
		$conta->observacoes = $observacoes;

		atualiza_conta($conta->id, $conta);

		echo "<script> window.location.href='senhassalvas.php';	 </script>";
		exit();
	}


?>
