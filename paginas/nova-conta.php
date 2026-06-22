<?php
// paginas/nova-conta.php

session_set_cookie_params(["httponly" => true]);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conexao.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/conta.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/usuario.php");

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {

    echo "<script> window.location.href='../login.php'; </script>";
    exit();
}

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $plataforma   = trim($_POST['plataforma'] ?? '');
    $url          = trim($_POST['url'] ?? '');
    $email_conta  = trim($_POST['email_conta'] ?? '');
    $login        = trim($_POST['login'] ?? '');
    $senha        = $_POST['senha'] ?? '';
    $observacoes  = trim($_POST['observacoes'] ?? '');

    if (empty($plataforma) || empty($senha)) {
        $erro = "Plataforma e Senha são obrigatórios!";
    } else {
        $novaConta = new Conta();
        $novaConta->id_usuario   = $_SESSION['id_usuario'];
        $novaConta->plataforma   = $plataforma;
        $novaConta->url          = $url;
        $novaConta->email_conta  = $email_conta;
        $novaConta->login        = $login;
        $novaConta->senha        = $senha;           
        $novaConta->observacoes  = $observacoes;

        cria_conta($novaConta);
        
        // Redireciona após sucesso (evita reenvio ao atualizar)
        echo "<script> window.location.href='nova-conta.php?sucesso=1'; </script>";
        exit();
    }
}

// Verifica se veio de um cadastro bem-sucedido
if (isset($_GET['sucesso'])) {
    $sucesso = "Conta cadastrada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Conta - Jericó</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="./css/novaconta.css">
    <link rel="stylesheet" href="./css/padrao.css">
</head>
<body>

    <section class="formulario" style="max-width: 600px; margin: 40px auto; padding: 30px;">
        <h1 class="titulo">Nova Conta</h1>

        <?php if ($erro): ?>
            <section style="background:#EF4444; color:white; padding:15px; border-radius:8px; margin-bottom:20px; text-align:center;">
                <?= $erro ?>
            </section>
        <?php endif; ?>

        

        <form action="" method="POST">
            
            <section class="campo">
                <label for="Plataforma">Plataforma / Site *</label>
                <input type="text" name="plataforma" id="Plataforma" value="<?= htmlspecialchars($_POST['plataforma'] ?? '') ?>" required>
            </section>

            <section class="campo">
                <label for="url">URL (opcional)</label>
                <input type="url" name="url" id="url" value="<?= htmlspecialchars($_POST['url'] ?? '') ?>" placeholder="https://">
            </section>

            <section class="campo">
                <label for="email">E-mail da conta</label>
                <input type="email" id="email" name="email_conta" value="<?= htmlspecialchars($_POST['email_conta'] ?? '') ?>">
            </section>

            <section class="campo">
                <label for="user">Login / Usuário</label>
                <input type="text" id="user" name="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
            </section>

            <section class="campo">
                <label for="senha">Senha *</label>
                <input type="password" id="senha" name="senha" required>
            </section>

            <section class="campo">
                <label for="obs">Observações</label>
                <textarea name="observacoes" id="obs" rows="4"><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
            </section>

            <section class="campo">
                <input type="submit" value="Cadastrar Conta">
                <p style="text-align:center; margin-top:15px;">
                    <a href="senhassalvas.php">Voltar para suas  contas</a>
                </p>
            </section>
        </form>
    </section>

</body>
</html>