<?php
require_once __DIR__ . "/../controller/authController.php";
require_once __DIR__ . "/../../config/init.php";

AuthController::verificarAcesso(['ESCALANTE', 'SGTE']);

$db = Database::getConnection();
// Busca baixas/indisponibilidades aprovadas para alertar o escalante[span_4](start_span)[span_4](end_span)
$stmt = $db->query("
    SELECT m.nome_guerra, n.data_inicio, n.data_fim, n.motivo 
    FROM necessidades n 
    JOIN militares m ON n.militar_id = m.id 
    WHERE n.status = 'APROVADO'
");
$impedimentos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerar Escala</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .alert-box { background: #fff3cd; border-left: 5px solid #ffc107; padding: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <h2>Escalar Militares</h2>
    <a href="/Escalex/src/views/menu_escalante.php">Voltar ao Menu</a>
    <br><br>

    <div class="card">
        <h3>Avisos de Indisponibilidade Aprovados</h3>
        <?php if (empty($impedimentos)): ?>
            <p>Nenhum militar indisponível para os próximos dias.</p>
        <?php else: ?>
            <div class="alert-box">
                <ul>
                    <?php foreach ($impedimentos as $imp): ?>
                        <li>
                            <strong><?= htmlspecialchars($imp['nome_guerra']) ?></strong>: 
                            Indisponível de <?= date('d/m/Y', strtotime($imp['data_inicio'])) ?> a <?= date('d/m/Y', strtotime($imp['data_fim'])) ?> 
                            (Motivo: <?= htmlspecialchars($imp['motivo']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>Gerar Nova Escala</h3>
        <form action="/Escalex/public/processar_escala.php" method="POST">
            <label>Data do Serviço:</label><br>
            <input type="date" name="data_servico" required><br><br>

            <label>Tipo de Escala:</label><br>
            <select name="tipo_escala_id" required>
                <option value="1">Escala 1</option>
                <option value="2">Escala 2</option>
                <option value="3">Escala 3</option>
                <option value="4">Escala 4</option>
            </select><br><br>

            <button type="submit" style="padding: 10px 15px; background: #1b5e20; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Gerar Automático com Critério de Desempate
            </button>
        </form>
    </div>

</body>
</html>