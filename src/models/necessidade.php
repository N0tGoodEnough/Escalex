<?php
require_once __DIR__ . '/../../config/database.php';

class Necessidade {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function cadastrar(int $militarId, string $dataInicio, string $dataFim, string $motivo): bool {
        $stmt = $this->db->prepare("
            INSERT INTO necessidade (militar_id, data_inicio, data_fim, motivo, status) 
            VALUES (:militar_id, :data_inicio, :data_fim, :motivo, 'PENDENTE')
        ");
        
        return $stmt->execute([
            ':militar_id' => $militarId,
            ':data_inicio' => $dataInicio,
            ':data_fim' => $dataFim,
            ':motivo' => htmlspecialchars($motivo, ENT_QUOTES, 'UTF-8') // Sanitização XSS
        ]);
    }

    public function atualizarStatus(int $necessidadeId, string $status, int $aprovadorId): bool {
        if (!in_array($status, ['APROVADO', 'REPROVADO'])) return false;

        $stmt = $this->db->prepare("
            UPDATE necessidade
            SET status = :status, aprovado_por = :aprovador_id 
            WHERE id = :id
        ");

        return $stmt->execute([
            ':status' => $status,
            ':aprovador_id' => $aprovadorId,
            ':id' => $necessidadeId
        ]);
    }
}
?>