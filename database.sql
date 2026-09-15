CREATE DATABASE IF NOT EXISTS escala_militar DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE escala_militar;

-- Usuários (Militares e Escalantes/SGTE)
CREATE TABLE IF NOT EXISTS militares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(11) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nome_guerra VARCHAR(100) NOT NULL,
    posto_graduacao VARCHAR(50) NOT NULL, -- Ex: 3º Sgt, Cb, Sd
    data_ingresso DATE NOT NULL, -- Desempate 1
    nota_curso DECIMAL(4,2) DEFAULT 0.00,
    data_nascimento DATE NOT NULL, -- Desempate 2
    perfil ENUM('MILITAR', 'ESCALANTE', 'SGTE') NOT NULL DEFAULT 'MILITAR',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Necessidades / Indisponividades
CREATE TABLE IF NOT EXISTS necessidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    militar_id INT NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    motivo TEXT NOT NULL,
    status ENUM('PENDENTE', 'APROVADO', 'REPROVADO') DEFAULT 'PENDENTE',
    aprovado_por INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (militar_id) REFERENCES militares(id),
    FOREIGN KEY (aprovado_por) REFERENCES militares(id)
);

-- Definição dos Tipos de Dias (Quadrinhos de Folga)
CREATE TABLE IF NOT EXISTS tipos_dias (
    data DATE PRIMARY KEY,
    tipo ENUM('PRETA', 'VERMELHA', 'ROXA') NOT NULL
);

-- Registros de Escalas
CREATE TABLE IF NOT EXISTS escalas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    militar_id INT NOT NULL,
    data_servico DATE NOT NULL,
    tipo_escala_id INT NOT NULL,
    FOREIGN KEY (militar_id) REFERENCES militares(id)
);