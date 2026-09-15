<?php
require_once __DIR__ . '/../src/controller/authController.php';
require_once __DIR__ . '/../src/models/necessidade.php';

authController::iniciarSessaoSegura();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataInicio = $_POST['data_inicio'] ?? '';
    $dataFim = $_POST['data_fim'] ?? '';
    $motivo = trim($_POST['motivo'] ?? '');
    $militarId = $_SESSION['usuario_id'] ?? 0;

    if (!empty($dataInicio) && !empty($dataFim) && !empty($motivo) && $militarId > 0) {
        $model = new Necessidade();
        if ($model->cadastrar($militarId, $dataInicio, $dataFim, $motivo)) {
            header("Location: /src/views/menuMilitar.php?sucesso=1");
            exit();
        }
    }
}

header("Location: /src/views/cadastrar_necessidade.php?erro=1");
exit();
?>