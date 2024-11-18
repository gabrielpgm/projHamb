<?php
// Configuração do banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = 'Ca190799';
$banco = 'hamburguer';

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para gerar o número do pedido
function gerarNumeroPedido($conn) {
    $mes = date('m'); // Mês atual
    $query = "SELECT COUNT(*) AS total FROM tb_pedidos WHERE MONTH(data_pedido) = MONTH(CURRENT_DATE) AND YEAR(data_pedido) = YEAR(CURRENT_DATE)";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $numeroSequencial = str_pad($row['total'] + 1, 4, '0', STR_PAD_LEFT);
        return "P-$mes-$numeroSequencial"; // Exemplo: P-01-0001
    } else {
        return "Erro ao gerar número de pedido";
    }
}

// Recebe os dados enviados via AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Validação para garantir que os dados são válidos
if (!isset($data['produtos']) || !is_array($data['produtos']) || empty($data['produtos'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Nenhum produto no pedido ou dados inválidos.'
    ]);
    exit; // Interrompe a execução caso a validação falhe
}

$produtos = $data['produtos']; // Após validar, armazena os produtos em uma variável
$nr_pedido = gerarNumeroPedido($conn); // Gerar número do pedido

// Inicia a transação
$conn->begin_transaction();

try {
    // Insere os dados do pedido na tabela tb_pedidos
    $stmt_pedido = $conn->prepare("INSERT INTO tb_pedidos (nr_pedido, id_produto, qtd_item, data_pedido) VALUES (?, ?, ?, NOW())");

    foreach ($produtos as $produto) {
        $stmt_pedido->bind_param("sii", $nr_pedido, $produto['id_produto'], $produto['qtd_item']);
        if (!$stmt_pedido->execute()) {
            throw new Exception("Erro ao inserir pedido: " . $stmt_pedido->error);
        }
    }

    // Confirma a transação
    $conn->commit();

    // Retorna uma resposta de sucesso
    echo json_encode(['status' => 'success', 'message' => 'Pedido realizado com sucesso!', 'nr_pedido' => $nr_pedido]);
} catch (Exception $e) {
    // Se houver erro, faz o rollback da transação
    $conn->rollback();
    // Retorna uma resposta de erro
    echo json_encode(['status' => 'error', 'message' => 'Erro ao realizar pedido: ' . $e->getMessage()]);
}

$conn->close();
?>
