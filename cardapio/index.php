<?php
// Configurações do banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = 'Ca190799';
$banco = 'hamburguer';

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter as categorias
$sql_categoria = "SELECT * FROM tb_categoria";
$result_categoria = $conn->query($sql_categoria);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cardápio Online</title>
</head>

<body>
    <div class="container">
        <h1>Cardápio</h1>

        <?php
        // Exibe as categorias e produtos
        if ($result_categoria->num_rows > 0) {
            while ($row_categoria = $result_categoria->fetch_assoc()) {
                echo "<h2>" . $row_categoria['descricao'] . "</h2>";

                // Consulta para obter os produtos da categoria atual
                $sql_produtos = "SELECT * FROM tb_produtos WHERE categoria = " . $row_categoria['id'];
                $result_produtos = $conn->query($sql_produtos);

                if ($result_produtos->num_rows > 0) {
                    echo "<ul>";
                    while ($row_produto = $result_produtos->fetch_assoc()) {
                        echo "<li>" . $row_produto['nome'] . " - R$ " . number_format($row_produto['preco'], 2, ',', '.') . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Sem produtos disponíveis nesta categoria.</p>";
                }
            }
        } else {
            echo "Nenhuma categoria encontrada.";
        }

        // Fecha a conexão
        $conn->close();
        ?>
    </div>
</body>

</html>