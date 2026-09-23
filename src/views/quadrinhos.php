<?php
require_once __DIR__ . "/../controller/authController.php";
require_once __DIR__ . "/../../config/init.php";

authController::verificarAcesso(['ESCALANTE', 'SGTE']);

$db = Database::getConnection();
$stmt = $db->query("SELECT id, posto_graduacao, nome_guerra FROM militares ORDER BY posto_graduacao DESC");
$militares = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Controle de Folgas - Quadrinhos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #2c3e50; color: white; }
        .cor-preta { color: #000000; font-weight: bold; }
        .cor-vermelha { color: #d32f2f; font-weight: bold; }
        .cor-roxa { color: #7b1fa2; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Controle de Folgas (Quadrinhos)</h2>
    <a href="/Escalex/src/views/menu_escalante.php">Voltar ao Menu</a>

    <table>
        <thead>
            <tr>
                <th>Militar</th>
                <th class="cor-preta">Dias Úteis (Preta)</th>
                <th class="cor-vermelha">Fins de Semana (Vermelha)</th>
                <th class="cor-roxa">Feriados (Roxa)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($militares as $m): ?>
            <tr>
                <td style="text-align: left;"><?= htmlspecialchars($m['posto_graduacao'] . ' ' . $m['nome_guerra']) ?></td>
                <!-- Exemplo simplificado de renderização dos contadores por tipo de folga -->
                <td class="cor-preta">0</td>
                <td class="cor-vermelha">0</td>
                <td class="cor-roxa">0</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>