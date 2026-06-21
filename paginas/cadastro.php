<?php
// cadastro.php

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conexao.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/usuario.php");

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['user'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $senha    = $_POST['senha'] ?? '';
    $senha2   = $_POST['senha_confirmation'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif ($senha !== $senha2) {
        $erro = "As senhas não coincidem!";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } else {
        $usuarioExistente = pega_usuario($email);
        
        if ($usuarioExistente !== null) {
            $erro = "Já existe uma conta com este e-mail!";
        } else {
            cria_usuario($nome, $email, $senha);
            $sucesso = "Cadastro realizado com sucesso! <a href='login.php'>Faça login agora</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Jericó</title>
    
    <link rel="stylesheet" href="css/cadastrologin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="imagem">
        <img src="img/cadastro.png" alt="">
    </section>

    <section class="formulario">
        <h1 class="titulo cor">Faça o seu cadastro</h1>

        <?php if ($erro): ?>
            <section style="background: #EF4444; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                <?= $erro ?>
            </section>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <section style="background: #22C55E; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                <?= $sucesso ?>
            </section>
        <?php endif; ?>

        <form action="" method="POST" autocomplete="on">
            
            <section class="campo">
                <label for="user" class="cor">Usuário</label>
                <input type="text" id="user" name="user" 
                       value="<?= htmlspecialchars($_POST['user'] ?? '') ?>" autocomplete="username" required>
            </section>

            <section class="campo">
                <label for="email" class="cor">E-mail:</label>
                <input type="email" id="email" name="email" 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email" required>
            </section>

            <section class="campo">
                <label for="senha" class="cor">Senha:</label>
                <input type="password" id="senha" name="senha" class="senha" autocomplete="new-password" required>
            </section>

            <section class="campo">
                <label for="senha2" class="cor">Confirmar senha:</label>
                <input type="password" id="senha2" name="senha_confirmation" class="senha2" autocomplete="new-password" required>
            </section>

            <section class="campo">
                <input type="submit" value="Cadastrar">
                <p class="texto-botao">Já tem uma conta? <span><a href="login.php">Entrar</a></span></p>
            </section>
        </form>
    </section>
</body>
</html>