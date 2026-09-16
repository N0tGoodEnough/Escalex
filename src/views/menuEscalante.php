<?php
require_once __DIR__ . '/../controller/authController.php';

// Proteção da tela: acesso restrito ao perfil Escalante e SGTE[span_6](start_span)[span_6](end_span)
authController::verificarAcesso(['ESCALANTE', 'SGTE']);

$nomeGuerra = $_SESSION['nome_guerra'] ?? 'Escalante';
$perfil = $_SESSION['perfil'] ?? 'ESCALANTE';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Painel do Escalante / SGTE </title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; }
        .card { background: white; padding: 25px; border-radius: 8px; max-width: 600px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn-grid { display: grid; grid-template-columns: 1fr; gap: 10px; margin-top: 15px; }
        .btn-admin { display: block; padding: 14px; background: #1b5e20; color: white; text-align: center; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-admin:hover { background: #2e7d32; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Painel de Gerenciamento (<?= htmlspecialchars($perfil) ?>)</h2>
        <p>Usuário Ativo: <strong><?= htmlspecialchars($nomeGuerra) ?></strong></p>

        <!-- Menu com os 5 botões de navegação solicitados no projeto -->
        <div class="btn-grid">
            <!-- Botão 1: Escalar (Gerador com regras de desempate) -->
            <a href="/src/views/escalar.php" class="btn-admin">
                1. Escalar
            </a>

            <!-- Botão 2: Consultar (Visualiza todas as escalas geradas) -->
            <a href="/src/views/consultar_todas_escalas.php" class="btn-admin">
                2. Consultar Escalas
            </a>

            <!-- Botão 3: Aprovar Necessidades (Deferir ou Indeferir justificativas) -->
            <a href="/src/views/aprovar_necessidade.php" class="btn-admin">
                3. Aprovar Necessidades
            </a>

            <!-- Botão 4: Quadrinhos (Matriz de folgas e contagem de cores) -->
            <a href="/src/views/quadrinhos.php" class="btn-admin">
                4. Quadrinhos (Controle de Folgas)
            </a>

            <!-- Botão 5: Cadastro de Militar (Inserção de dados e critérios de desempate) -->
            <a href="/src/views/cadastrar_militar.php" class="btn-admin">
                5. Cadastro de Militar
            </a>

            <!-- Botão 6: Edição de Militar ja Cadastrado (Inserção de dados e critérios de desempate) -->
            <a href="/src/views/gerenciar_militares.php" class="btn-admin" style="background-color: #2980b9;">
                Gerenciar Militares (Editar / Excluir)
            </a>
        </div>

        <hr style="margin-top: 25px;">
        <a href="/public/logout.php" style="color: #c0392b; text-decoration: none;">Sair do Sistema</a>
    </div>

</body>
</html>