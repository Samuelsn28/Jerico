<?php

session_set_cookie_params(["httponly" => true]);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conexao.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/usuario.php");

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = "E-mail e senha são obrigatórios!";
    } else {
        $resultado = permite_acesso_conta($email, $senha);

        if ($resultado === true) {
            // Login bem-sucedido
            $usuario = pega_usuario($email);
            
            session_start();
            $_SESSION['id_usuario'] = $usuario->id;
            $_SESSION['nome'] = $usuario->nome;
            $_SESSION['email'] = $usuario->email;

            echo "<script> window.location.href='senhassalvas.php'; </script>";
            exit();
        } 
        elseif ($resultado === false) {
            $erro = "Senha incorreta!";
        } 
        else {
            $erro = "E-mail não encontrado!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jericó Guardião</title>
    
    <link rel="stylesheet" href="./css/cadastrologin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="imagem" style="margin-right: 100px;">
        <figure>
            <img src="img/login.png" alt="">
        </figure>
    </section>

    <section class="formulario">
        <h1 class="titulo titulo-login cor">Bem-vindo de volta</h1>
        
        <?php if ($erro): ?>
            <section style="background: #EF4444; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                <?= $erro ?>
            </section>
        <?php endif; ?>

        <form action="" method="POST" autocomplete="on">
            <section class="campo">
                <label for="email" class="cor">E-mail:</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    autocomplete="email"
                    required
                />
            </section>

            <section class="campo">
                <label for="senha" class="cor">Senha:</label>
                <input
                    type="password"
                    name="senha"
                    id="senha"
                    class="senha"
                    autocomplete="current-password"
                    required
                />
            </section>

            <section class="campo">
                <input type="submit" value="Login" />
                <p class="texto-botao">
                    Sem conta? <span><a href="cadastro.php">Criar uma agora</a></span>
                </p>
            </section>
        </form>
    </section>
</body>
</html>