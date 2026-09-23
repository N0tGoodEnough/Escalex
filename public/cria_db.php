<?php

    $host = "localhost"; // endereço do servidor

    $port = "3306"; // porta do Mysql

    $dbname = "Escalex"; // nome do DB

    $user = "root"; // usuario que acessa o DB

    $password = ""; // senha do DB


    // Usuário 1: Admin / Escalante
    $cpfAdmin   = "11111111111";
    $senhaAdmin = password_hash("admin123", PASSWORD_DEFAULT);

    // Usuário 2: SGTE
    $cpfSgte   = "22222222222";
    $senhaSgte = password_hash("sgte123", PASSWORD_DEFAULT);
        
    try {
        // 1. Conecta ao MySQL para criar o banco de dados se ele não existir
        $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        $pdo->exec("USE $dbname");

        $sql= "
        
            CREATE TABLE IF NOT EXISTS militares (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cpf VARCHAR(11) UNIQUE NOT NULL,
                password_hash VARCHAR(255) NOT NULL,
                nome_guerra VARCHAR(100) NOT NULL,
                posto_graduacao VARCHAR(50) NOT NULL,
                data_ingresso DATE NOT NULL,
                nota_curso DECIMAL(4,2) DEFAULT 0.00,
                data_nascimento DATE NOT NULL,
                perfil ENUM('MILITAR', 'ESCALANTE', 'SGTE') NOT NULL DEFAULT 'MILITAR',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        
            CREATE TABLE IF NOT EXISTS necessidades (
                id INT AUTO_INCREMENT PRIMARY KEY,
                militar_id INT NOT NULL,
                data_inicio DATE NOT NULL,
                data_fim DATE NOT NULL,
                motivo TEXT NOT NULL,
                status ENUM('PENDENTE', 'APROVADO', 'REPROVADO') DEFAULT 'PENDENTE',
                aprovado_por INT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (militar_id) REFERENCES militares(id) ON DELETE CASCADE,
                FOREIGN KEY (aprovado_por) REFERENCES militares(id) ON DELETE SET NULL
            )

            CREATE TABLE IF NOT EXISTS tipos_dias (
                data DATE PRIMARY KEY,
                tipo ENUM('PRETA', 'VERMELHA', 'ROXA') NOT NULL
            )

            CREATE TABLE IF NOT EXISTS escalas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                militar_id INT NOT NULL,
                data_servico DATE NOT NULL,
                tipo_escala_id INT NOT NULL,
                FOREIGN KEY (militar_id) REFERENCES militares(id) ON DELETE CASCADE
            )

            -- Inclusão do Admin no sistema
            INSERT INTO militares (cpf, password_hash, nome_guerra, posto_graduacao, data_ingresso, nota_curso, data_nascimento, perfil)
            SELECT ($cpfAdmin, $senhaAdmin, 'ADMIN', '3º Sgt', '2010-02-01', 9.50, '1990-05-15', 'ESCALANTE')

            -- Inclusão do SGTE no sistema
            INSERT INTO militares (cpf, password_hash, nome_guerra, posto_graduacao, data_ingresso, nota_curso, data_nascimento, perfil)
            SELECT ($cpfSgte, $senhaSgte, 'SGTE', '1º Sgt', '2012-03-01', 8.80, '1992-08-20', 'SGTE')

        "
        
        // =========================================================================
        // 6. CADASTRO PRÉ-CONFIGURADO DOS 2 USUÁRIOS INICIAIS
        // =========================================================================

        // Inserção do Usuário 1 (Escalante/Admin)
        $stmt1 = $pdo->prepare("
            INSERT INTO militares (cpf, password_hash, nome_guerra, posto_graduacao, data_ingresso, nota_curso, data_nascimento, perfil)
            VALUES (:cpf, :password_hash, 'ADMIN', '3º Sgt', '2010-02-01', 9.50, '1990-05-15', 'ESCALANTE')
            ON DUPLICATE KEY UPDATE cpf=cpf
        ");
        $stmt1->execute([
            ':cpf' => $cpfAdmin,
            ':password_hash' => $senhaAdmin
        ]);

        // Inserção do Usuário 2 (SGTE)
        $stmt2 = $pdo->prepare("
            INSERT INTO militares (cpf, password_hash, nome_guerra, posto_graduacao, data_ingresso, nota_curso, data_nascimento, perfil)
            VALUES (:cpf, :password_hash, 'SILVA', '1º Sgt', '2012-03-01', 8.80, '1992-08-20', 'SGTE')
            ON DUPLICATE KEY UPDATE cpf=cpf
        ");
        $stmt2->execute([
            ':cpf' => $cpfSgte,
            ':password_hash' => $senhaSgte
        ]);

        // Mensagem de confirmação na tela
        echo "<h2>Banco de dados 'Escalex' e tabelas criados com sucesso!</h2>";

        echo "</ul>";

        echo "<a href='/projeto-escala/public/login.php'>Clique aqui para ir para a tela de Login</a>";

    } 
        catch (PDOException $e) {
            die("Erro ao criar a base de dados: " . $e->getMessage());
    }
?>