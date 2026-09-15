<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controller/authController.php';

authController::iniciarSessaoSegura();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
    $senha = $_POST['senha'] ?? '';



    if (!empty($cpf) && !empty($senha)) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM militares WHERE cpf = :cpf LIMIT 1");
        $stmt->execute([':cpf' => $cpf]);
        $usuario = $stmt->fetch();

        // Validação da senha criptografada
        if ($usuario && password_verify($senha, $usuario['password_hash'])) {
            // Define variáveis da sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome_guerra'] = $usuario['nome_guerra'];
            $_SESSION['perfil'] = $usuario['perfil'];

            // Redireciona conforme o perfil[span_2](start_span)[span_2](end_span)
            if (in_array($usuario['perfil'], ['ESCALANTE', 'SGTE'])) {
                header("Location: /Escalex/src/views/menu_escalante.php");
            } else {
                header("Location: /Escalex/src/views/menu_militar.php");
            }
            exit();
        }
    }
}

header("Location: /Escalex/public/login.php?erro=1");
exit();
?>