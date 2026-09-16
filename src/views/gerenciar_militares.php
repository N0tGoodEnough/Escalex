<?php
    require_once __DIR__ . "/../controller/authController.php";
    require_once __DIR__ . "/../../config/database.php";

    // Permite o acesso apenas ao perfil Escalante e SGTE[cite: 1]
    authController::verificarAcesso(['ESCALANTE', 'SGTE']);

    $db = Database::getConnection();
    $stmt = $db->query("SELECT id, cpf, nome_guerra, posto_graduacao, data_ingresso, nota_curso, data_nascimento, perfil FROM militares ORDER BY posto_graduacao DESC, nome_guerra ASC");
    $militares = $stmt->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Gerenciar Militares</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
            .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            th { background: #2c3e50; color: white; }
            .btn-editar { background: #f39c12; color: white; padding: 6px 10px; text-decoration: none; border-radius: 4px; font-weight: bold; }
            .btn-excluir { background: #c0392b; color: white; padding: 6px 10px; text-decoration: none; border-radius: 4px; font-weight: bold; }
            .alert { padding: 10px; background: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 15px; }
        </style>
    </head>
    <body>

    <div class="container">
        <h2>Gerenciamento de Militares</h2>
        <a href="/Escalex/src/views/menu_escalante.php" style="display: inline-block; margin-bottom: 15px;">Voltar ao Menu</a>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert">Operação realizada com sucesso!</div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Posto/Grad</th>
                    <th>Nome de Guerra</th>
                    <th>CPF</th>
                    <th>Data Ingresso</th>
                    <th>Data Nasc.</th>
                    <th>Nota</th>
                    <th>Perfil</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($militares as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['posto_graduacao']) ?></td>
                    <td><?= htmlspecialchars($m['nome_guerra']) ?></td>
                    <td><?= htmlspecialchars($m['cpf']) ?></td>
                    <td><?= date('d/m/Y', strtotime($m['data_ingresso'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($m['data_nascimento'])) ?></td>
                    <td><?= number_format($m['nota_curso'], 2, ',', '.') ?></td>
                    <td><strong><?= htmlspecialchars($m['perfil']) ?></strong></td>
                    <td>
                        <a href="/Escalex/src/views/editar_militar.php?id=<?= $m['id'] ?>" class="btn-editar">Editar</a>
                        <a href="/Escalex/public/processar_exclusao_militar.php?id=<?= $m['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este militar?');">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    </body>
</html>