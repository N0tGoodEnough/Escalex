<?php
require_once __DIR__ . "/../controller/authController.php";
require_once __DIR__ . "/../../config/init.php";

AuthController::verificarAcesso(['ESCALANTE', 'SGTE']);

$db = Database::getConnection();
$stmt = $db->query("
    SELECT n.id, m.nome_guerra, m.posto_graduacao, n.data_inicio, n.data_fim, n.motivo, n.status 
    FROM necessidades n
    JOIN militares m ON n.militar_id = m.id
    ORDER BY n.created_at DESC
");
$necessidades = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Aprovar Necessidades</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #2c3e50; color: white; }
        .btn-aprovar { background: #27ae60; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-reprovar { background: #c0392b; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>

    <h2>Aprovação de Necessidades / Dispensas</h2>
    <a href="/Escalex/src/views/menu_escalante.php">Voltar ao Menu</a>

    <table>
        <thead>
            <tr>
                <th>Militar</th>
                <th>Período</th>
                <th>Motivo</th>
                <th>Status Atual</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($necessidades as $n): ?>
            <tr>
                <td><?= htmlspecialchars($n['posto_graduacao'] . ' ' . $n['nome_guerra']) ?></td>
                <td><?= date('d/m/Y', strtotime($n['data_inicio'])) ?> até <?= date('d/m/Y', strtotime($n['data_fim'])) ?></td>
                <td><?= htmlspecialchars($n['motivo']) ?></td>
                <td><strong><?= $n['status'] ?></strong></td>
                <td>
                    <?php if ($n['status'] === 'PENDENTE'): ?>
                        <a href="/Escalex/public/processar_status_necessidade.php?id=<?= $n['id'] ?>&status=APROVADO" class="btn-aprovar">Aprovar</a>
                        <a href="/Escalex/public/processar_status_necessidade.php?id=<?= $n['id'] ?>&status=REPROVADO" class="btn-reprovar">Reprovar</a>
                    <?php else: ?>
                        Concluido
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>