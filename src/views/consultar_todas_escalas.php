<?php
require_once __DIR__ . "/../controller/authController.php";
require_once __DIR__ . "/../../config/init.php";

AuthController::verificarAcesso(['ESCALANTE', 'SGTE']);

$db = Database::getConnection();
$stmt = $db->query("
    SELECT e.data_servico, e.tipo_escala_id, m.posto_graduacao, m.nome_guerra 
    FROM escalas e
    JOIN militares m ON e.militar_id = m.id
    ORDER BY e.data_servico DESC
");
$escalas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta Geral de Escalas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2c3e50; color: white; }
    </style>
</head>
<body>

    <h2>Todas as Escalas Publicadas</h2>
    <!-- Botão voltar ao menu conforme exigido no fluxo -->
    <a href="/Escalex/src/views/menu_escalante.php" style="display: inline-block; padding: 8px 12px; background: #7f8c8d; color: white; text-decoration: none; border-radius: 4px;">
        Voltar ao Menu
    </a>

    <table>
        <thead>
            <tr>
                <th>Data do Serviço</th>
                <th>Tipo de Escala</th>
                <th>Militar Escalado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($escalas)): ?>
                <tr>
                    <td colspan="3">Nenhuma escala cadastrada até o momento.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($escalas as $esc): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($esc['data_servico'])) ?></td>
                    <td>Escala nº <?= $esc['tipo_escala_id'] ?></td>
                    <td><?= htmlspecialchars($esc['posto_graduacao'] . ' ' . $esc['nome_guerra']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>