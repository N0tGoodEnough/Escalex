<?php
// Credenciais de acesso ao BD
//==========================================
$host = "localhost"; // endereço do servidor

$port = "3306"; // porta do Mysql

$dbname = "Escalex"; // nome do BD

$user = "root"; // usuario que acessa o BD

$password = ""; // senha do BD

//==========================================
// Conexao com o BD
//==========================================
try {
    $conexao = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );
    //==========================================
    // Força o PDO a lançar exceções (erros) em caso de falhas no banco (para ser usado com TRY CATCH)
    //==========================================
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define o FETCH_ASSOC como padrão do projeto, retornando um array associativo a toda consulta ao banco. (Não precisa passar mais o parâmetro ao método execute())
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}
catch (PDOException $e){
    if ($e->getCode() == 2002) {
        echo "<h2>Não foi possível conectar com o servidor do banco de dados.</h2>";
        echo "<p>Verifique se o serviço está ativo.</p>";
    } else {
        echo "Erro: " . $e->getMessage();
    }
}
?>