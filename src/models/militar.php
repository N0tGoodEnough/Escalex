<?php
require_once __DIR__ . '/../../config/database.php';

class Militar {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function buscarEmpatados(array $idsMilitares): array {
        if (empty($idsMilitares)) return [];

        $placeholders = implode(',', array_fill(0, count($idsMilitares), '?'));
        $stmt = $this->db->prepare("SELECT * FROM militares WHERE id IN ($placeholders)");
        $stmt->execute($idsMilitares);
        
        return $stmt->fetchAll();
    }

    // Regra oficial de desempate
    public function desempateEscala(array $militares): array {
        usort($militares, function($a, $b) {
            // 1. Menor tempo de serviço (Data de ingresso mais recente) é escalado primeiro[span_0](start_span)[span_0](end_span)
            if ($a['data_ingresso'] !== $b['data_ingresso']) {
                return strcmp($b['data_ingresso'], $a['data_ingresso']); 
            }

            // 2. Data de nascimento mais distante de 01/Jan do mesmo ano[span_1](start_span)[span_1](end_span)
            $distanciaA = (int)(new DateTime($a['data_nascimento']))->format('z'); // Dia do ano (0 a 365)[span_2](start_span)[span_2](end_span)
            $distanciaB = (int)(new DateTime($b['data_nascimento']))->format('z');

            return $distanciaB <=> $distanciaA; // Maior distância é o selecionado[span_3](start_span)[span_3](end_span)
        });

        // Retorna o militar selecionado para entrar de serviço[span_4](start_span)[span_4](end_span)
        return $militares[0]; 
    }
}
?>