<?php
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'escala_militar');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    class Database {
        private static ?PDO $instance = null;

        public static function getConnection(): PDO {
            if (self::$instance === null) {
                try {
                    self::$instance = new PDO(
                        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                        DB_USER,
                        DB_PASS,
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false,
                        ]
                    );
                } catch (PDOException $e) {
                    // Oculta detalhes do erro em produção para evitar vazamento de informações do servidor
                    die("Erro na conexo com o banco de dados.");
                }
            }
            return self::$instance;
        }
    }
?>