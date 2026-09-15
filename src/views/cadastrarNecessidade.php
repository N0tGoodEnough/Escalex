<?php
require_once __DIR__ . '/../controller/authController.php';
authController::verificarAcesso(['MILITAR', 'ESCALANTE', 'SGTE']); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Necessidade</title>
</head>
<body>
    <h2>Cadastrar Indisponibilidade para Escala</h2>
    
    <form action="/public/processar_necessidade.php" method="POST">
        <label for="data_inicio">Data Inicial:</label>
        <input type="date" id="data_inicio" name="data_inicio" required><br><br>

        <label for="data_fim">Data Final:</label>
        <input type="date" id="data_fim" name="data_fim" required><br><br>

        <label for="motivo">Motivo/Justificativa:</label><br>
        <textarea id="motivo" name="motivo" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Enviar para Aprovação</button>
        <a href="/src/Views/menu_militar.php">Voltar ao Menu</a>
    </form>
</body>
</html>