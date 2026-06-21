<?php


require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conexao.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/conta.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/modelo/usuario.php");

session_start();

// Proteção de acesso
if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario = (int)$_SESSION['id_usuario'];
$contas = pega_contas($id_usuario);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Contas - Jericó</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="./css/padrao.css">
    <link rel="stylesheet" href="./css/pagina-principal.css">
</head>
<body>

    <!-- Sidebar -->
    <section class="sidebar">
        <section class="logo"></section>
        
        <ul class="nav-menu">
            <li class="nav-item active">
                <i class="fas fa-key"></i>
                <span>Minhas Contas</span>
            </li>
            <li class="nav-item" onclick="location.href='nova-conta.php'">
                <i class="fas fa-plus-circle"></i>
                <span>Nova Conta</span>
            </li>
            <li class="nav-item">
                <i class="fas fa-user-shield"></i>
                <span>Perfil</span>
            </li>
        </ul>
    </section>

    <!-- Main Content -->
    <section class="main">
        <section class="header">
            <h1>Minhas Contas</h1>
            <a href="nova-conta.php" class="nova">
                <i class="fas fa-plus"></i> Nova Conta
            </a>
        </section>

        <section class="contas-grid">
            <?php if (empty($contas)): ?>
                <p style="grid-column: 1/-1; text-align: center; font-size: 1.4rem; opacity: 0.7; padding: 4rem 0;">
                    Nenhuma conta cadastrada ainda.<br>
                    <small>ID do usuário: <?= $id_usuario ?></small>
                </p>
            <?php else: ?>
                <?php foreach ($contas as $conta): ?>
                <section class="conta-card">
                    <section class="card-header">
                        <section class="platform"><?= htmlspecialchars($conta->plataforma ?? 'Sem nome') ?></section>
                        <?php if (!empty($conta->url)): ?>
                            <a href="<?= htmlspecialchars($conta->url) ?>" target="_blank" style="color:white;">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        <?php endif; ?>
                    </section>
                    
                    <section class="card-body">
                        <section class="field">
                            <section class="field-label">E-mail</section>
                            <section class="field-value">
                                <?= htmlspecialchars($conta->email_conta ?: $conta->login ?? 'Não informado') ?>
                            </section>
                        </section>

                        <section class="field">
                            <section class="field-label">Senha</section>
                            <section class="senha-container">
                                <section class="field-value" id="senha-<?= $conta->id ?>" style="flex:1;">
                                    ●●●●●●●●
                                </section>
                                <button class="mostrar" onclick="toggleSenha(<?= $conta->id ?>, '<?= htmlspecialchars(addslashes($conta->senha ?? '')) ?>')">
                                     Mostrar
                                </button>
                            </section>
                        </section>

                        <?php if (!empty($conta->observacoes)): ?>
                        <section class="field">
                            <section class="field-label">Observações</section>
                            <section class="field-value"><?= htmlspecialchars($conta->observacoes) ?></section>
                        </section>
                        <?php endif; ?>
                    </section>

                    <section class="acoes">
                        <button class="btn btn-edit" onclick="location.href='editar-conta.php?id=<?= $conta->id ?>'">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-delete" onclick="if(confirm('Excluir esta conta?')) location.href='deletar-conta.php?id=<?= $conta->id ?>'">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </section>
                </section>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </section>
<script>
        function toggleSenha(id, senhaReal) {
            const campo = document.getElementById('senha-' + id);
            const botao = campo.parentElement.querySelector('button');
            
            if (campo.textContent.includes('●')) {
                campo.textContent = senhaReal;
                botao.textContent = ' Ocultar';
            } else {
                campo.textContent = '●●●●●●●●';
                botao.textContent = ' Mostrar';
            }
        }
    </script>
  
   
</body>
</html>