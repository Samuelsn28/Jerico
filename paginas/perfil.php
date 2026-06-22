<?php

session_set_cookie_params(["httponly" => true]);
session_start();

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Jericó</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="./css/padrao.css">
    <link rel="stylesheet" href="./css/pagina-principal.css">
    <style>
        .nav-menu {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        #logo {
            flex: 1;
        }

        #logo > img {
            width: 100%;
            background: transparent;
        }

        .field-value {
            margin-bottom: 15px;
        }

        hr {
            margin: 15px 0;
        }
    </style>
</head>
<body>
	<section class="sidebar">
        <section class="logo"></section>
        
        <ul class="nav-menu">
            <li class="nav-item" onclick="location.href='senhassalvas.php'">
                <i class="fas fa-key"></i>
                <span>Minhas Contas</span>
            </li>
            <li class="nav-item" onclick="location.href='nova-conta.php'">
                <i class="fas fa-plus-circle"></i>
                <span>Nova Conta</span>
            </li>
            <li class="nav-item active">
                <i class="fas fa-user-shield"></i>
                <span>Perfil</span>
            </li>
            <li class="nav-item" onclick="location.href='sair.php'">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sair</span>
            </li>
            <li id="logo">
                <img src="img/logo.png">
            </li>
        </ul>
    </section>

    <section class="main">
        <p class="field-value">
            <strong class="field-label">Nome: &nbsp;</strong> <?= $_SESSION["nome"] ?>
        </p>
        <p class="field-value">
            <strong class="field-label">E-mail: &nbsp;</strong> <?= $_SESSION["email"] ?>
        </p>
        <hr>
        <button class="btn btn-delete" onclick="if(confirm('Tem certeza que deseja excluir sua conta?')) location.href='excluir.php?id=<?= $_SESSION["id_usuario"] ?>'">Excluir conta</button>
    </section>
</body>
</html>



