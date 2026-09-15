<?php
require_once __DIR__ . "/../src/controller/authController.php";
AuthController::iniciarSessaoSegura();

// Se o usuário já estiver logado, redireciona para o menu correspondente[span_0](start_span)[span_0](end_span)
if (isset($_SESSION['usuario_id'])) {
    if (in_array($_SESSION['perfil'], ['ESCALANTE', 'SGTE'])) {
        header("Location: /projeto-escala/src/views/menu_escalante.php");
    } else {
        header("Location: /projeto-escala/src/views/menu_militar.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Escala Militar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-card">
    <h2>Acesso ao Sistema</h2>
    
    <?php if (isset($_GET['erro'])): ?>
        <div class="error">CPF ou senha inválidos.</div>
    <?php endif; ?>

    <form action="/Escalex/public/processar_login.php" method="POST">
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="11" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>

        <button type="submit" class="btn-login">Entrar</button>
    </form>
</div>

</body>
</html>