<?php
require_once __DIR__ . "/../controller/authController.php";

// Proteção da tela: permite acesso a qualquer militar autenticado[span_3](start_span)[span_3](end_span)
authController::verificarAcesso(['MILITAR', 'ESCALANTE', 'SGTE']);

$nomeGuerra = $_SESSION['nome_guerra'] ?? 'Militar';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Militar - Sistema de Escala</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; max-width: 500px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn { display: block; width: 100%; padding: 12px; margin: 10px 0; background: #2c3e50; color: white; text-align: center; text-decoration: none; border-radius: 4px; font-weight: bold; box-sizing: border-box; }
        .btn:hover { background: #34495e; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Painel do Militar (M-U)</h2>
        <p>Bem-vindo, <strong><?= htmlspecialchars($nomeGuerra) ?></strong></p>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert-success">Sua solicitação de necessidade foi enviada com sucesso!</div>
        <?php endif; ?>

        <!-- Botão 1: Consultar Escala Própria -->
        <a href="/src/views/consultar_escala_militar.php" class="btn">
            Consultar Minha Escala
        </a>

        <!-- Botão 2: Cadastrar Indisponibilidade/Necessidade -->
        <a href="/src/views/cadastrar_necessidade.php" class="btn">
            Cadastrar Necessidade
        </a>

        <hr>
        <a href="/public/logout.php" style="color: #c0392b; text-decoration: none;">Sair da Conta</a>
    </div>

</body>
</html>