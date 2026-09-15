<?php
    class authController {
        public static function iniciarSessaoSegura(): void {
            if (session_status() === PHP_SESSION_NONE) {
                // Proteções contra Cross-Site Scripting (XSS) e Session Hijacking
                ini_set('session.cookie_httponly', 1);
                ini_set('session.use_only_cookies', 1);
                ini_set('session.cookie_samesite', 'Strict');
                session_start();
            }
        }

        public static function verificarAcesso(array $perfisPermitidos): void {
            self::iniciarSessaoSegura();

            if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['perfil'], $perfisPermitidos)) {
                header("Location: /public/login.php?erro=acesso_negado");
                exit();
            }
        }
    }
?>