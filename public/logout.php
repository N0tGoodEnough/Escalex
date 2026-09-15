<?php
require_once __DIR__ . '/../src/controller/authController.php';

authController::iniciarSessaoSegura();

// Limpa todas as variáveis da sessão e destrói o cookie
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header("Location: /public/login.php");
exit();
?>