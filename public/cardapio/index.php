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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
    <div class="superior">
        <div class="char">
            <button onclick="window.location.href='/public/home/index.php';">
                <i class="fa-solid fa-user-tie"></i>
            </button>
            
            <button onclick="ToggleCarrinho()">
                <i class="fa-solid fa-cart-shopping"></i>
            </button>
        </div>
    </div>

    <div class="container">
        <div class="carrinho" id="carrinho">
            <div class="carrinho-title"><span>Carrinho</span>
        </div>
            <br>
                <div class="carrinho-content" id="carrinho-content">
            
                </div>
            <br>
        <div class="carrinho-footer">
            <button onclick="realizarPedido()">Realizar Pedido</button>

        </div>
    </div>
    <div>
        
        <h1>Cardápio</h1>
        
        <?php
            // Exibe as categorias e produtos
            if ($result_categoria->num_rows > 0) {
                while ($row_categoria = $result_categoria->fetch_assoc()) {

                    // Define o mapeamento de categorias para ícones
                    $icones_categoria = [
                        'HAMBURGUER' => "<i class='fa-solid fa-burger'></i>",
                        'BEBIDAS' => "<i class='fa-solid fa-martini-glass'></i>",
                        'SOBREMESAS' => "<i class='fa-solid fa-ice-cream'></i>",
                        'COMBOS' => "<i class='fa-solid fa-ice-cream'></i>"
                    ];

                    // Determina o ícone baseado na descrição da categoria
                    $icone = $icones_categoria[$row_categoria['descricao']] ?? "<i class='fa-solid fa-box'></i>"; // Ícone padrão

                    // Exibe a categoria e o ícone
                    echo "<div class='categoria'>";
                    echo "<h2>$icone " . $row_categoria['descricao'] . "</h2>";

                    // Consulta para obter os produtos da categoria atual
                    $sql_produtos = "SELECT * FROM tb_produtos WHERE categoria = " . $row_categoria['id'];
                    $result_produtos = $conn->query($sql_produtos);
                    
                    if ($result_produtos->num_rows > 0) {
                        echo "<ul class='produtos'>";
                        while ($row_produto = $result_produtos->fetch_assoc()) {
                            echo "<li class='produto'>";
                    
                            // Exibe a imagem do produto
                            if ($row_produto['imagem']) {
                                echo "<div class='produto-imagem'>";
                                echo "<img src='/public/uploads/" . $row_produto['imagem'] . "' alt='" . htmlspecialchars($row_produto['nome'], ENT_QUOTES, 'UTF-8') . "' style='width: 100px; height: 100px;'>";
                                echo "</div>";
                            }
                    
                            // Exibe o nome do produto
                            echo "<div class='produto-nome'>";
                            echo "<strong>" . htmlspecialchars($row_produto['nome'], ENT_QUOTES, 'UTF-8') . "</strong>";
                            echo "</div>";
                    
                            // Exibe a descrição do produto
                            echo "<div class='produto-descricao'>";
                            echo htmlspecialchars($row_produto['descricao'], ENT_QUOTES, 'UTF-8');
                            echo "</div>";
                    
                            // Exibe o preço do produto
                            echo "<div class='produto-preco'>";
                            echo 'R$ ' . number_format($row_produto['preco'], 2, ',', '.');
                            echo "</div>";
                    
                            // Botão Adicionar ao Carrinho
                            echo '<div class="produto-botao">';
                            echo '<button id="botao" onclick="adicionarAoCarrinho({
                                id: ' . $row_produto['id'] . ', 
                                nome: \'' . addslashes($row_produto['nome']) . '\', 
                                imagem: \'/public/uploads/' . addslashes($row_produto['imagem']) . '\', 
                                qtd: 1, 
                                preco: ' . number_format($row_produto['preco'], 2, '.', '') . '})" 
                                value="' . $row_produto['id'] . '">
                                <i class="fas fa-cart-plus"></i>
                            </button>';
                            echo "</div>";
                    
                            echo "</li>";
                        }
                        echo "</ul>";
                    }
                     else {
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
    <div class="copy">
        <h2>Copyright &copy; 2024 - Todos os direitos reservados</h2>
        <div clas='dadoscont'>
            <button class="whatsapp-button" onclick="window.open('https://wa.me/5562984044513', '_blank')">
                <i class="fa-brands fa-whatsapp"></i>
                <i class="fa-solid fa-envelope"></i>
                    <span>oliveira.gbr@gmail.com</span>
        </div>
    </div>
</body>

<script src="js/cardapio.js"></script>

</html>