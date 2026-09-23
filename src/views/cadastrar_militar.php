<?php
require_once __DIR__ . "/../controller/authController.php";
AuthController::verificarAcesso(['ESCALANTE', 'SGTE']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Militar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
        .form-card { background: white; padding: 20px; border-radius: 8px; max-width: 500px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 4px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-submit { background: #1b5e20; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Cadastro de Militar</h2>
    <form action="/Escalex/public/processar_militar.php" method="POST">
        <div class="form-group">
            <label>CPF:</label>
            <input type="text" name="cpf" maxlength="11" required>
        </div>
        <div class="form-group">
            <label>Senha Inicial:</label>
            <input type="password" name="senha" required>
        </div>
        <div class="form-group">
            <label>Nome de Guerra:</label>
            <input type="text" name="nome_guerra" required>
        </div>
        <div class="form-group">
            <label>Posto / Graduação:</label>
            <input type="text" name="posto_graduacao" placeholder="Ex: 3º Sgt, Cb, Sd" required>
        </div>
        <div class="form-group">
            <label>Data de Ingresso (Exército):</label>
            <input type="date" name="data_ingresso" required>
        </div>
        <div class="form-group">
            <label>Nota de Curso:</label>
            <input type="number" step="0.01" name="nota_curso" min="0" max="10" required>
        </div>
        <div class="form-group">
            <label>Data de Nascimento:</label>
            <input type="date" name="data_nascimento" required>
        </div>
        <div class="form-group">
            <label>Perfil no Sistema:</label>
            <select name="perfil" required>
                <option value="MILITAR">Militar (M-U)</option>
                <option value="ESCALANTE">Escalante (M-E)</option>
                <option value="SGTE">SGTE (M-E)</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Salvar Militar</button>
        <a href="/Escalex/src/views/menu_escalante.php" style="margin-left: 10px;">Voltar ao Menu</a>
    </form>
</div>

</body>
</html>