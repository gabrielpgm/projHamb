let carrinho = [];


document.addEventListener("DOMContentLoaded", ()=>{
    let cart = document.getElementById("carrinho");
    cart.style.visibility = 'hidden';
})

function adicionarAoCarrinho(produto) {
    const produtoExistente = carrinho.find(item => item.id === produto.id);
    
    if (produtoExistente) {
        produtoExistente.qtd += produto.qtd;
    } else {
        carrinho.push({ ...produto }); 
    }

    // Atualiza o carrinho no localStorage
    localStorage.setItem('carrinho', JSON.stringify(carrinho));

    // Renderiza o carrinho e atualiza o ícone e o contador
    renderizarCarrinho();
    atualizarCarrinho(); // Chama para atualizar o ícone do carrinho
}

function renderizarCarrinho() {
    const carrinhoContent = document.getElementById('carrinho-content');
    carrinhoContent.innerHTML = ''; 
    
    let carrinhoHTML = '';
    
    carrinho.forEach(produto => {
        if (produto.qtd > 0) {
            carrinhoHTML += `
                <div class="pedidoscar">
                    <div class="image">
                        <img src="${produto.imagem || 'caminho/para/imagem_padrao.jpg'}" width="50px" alt="${produto.nome}">
                    </div>
                    <div class="nome">${produto.nome}</div>
                    <div class="qtd">
                        <button onclick="diminuiQuantidade(${produto.id})">-</button>
                         ${produto.qtd}
                        <button onclick="aumentarQuantidade(${produto.id})">+</button>
                    </div>
                    <div class="preco">
                        <span>R$${produto.preco.toFixed(2)}</span>
                    </div>
                </div>
            `;
        }
    });
    
    carrinhoContent.innerHTML = carrinhoHTML;
}

// Função para atualizar o ícone do carrinho e o contador
function atualizarCarrinho() {
    const carrinhoIcone = document.querySelector('.fa-cart-shopping');
    const contadorCarrinho = document.getElementById('contador-carrinho');
    
    // Obtém o carrinho do localStorage
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    // Se houver itens no carrinho, aplica a animação e exibe o contador
    if (carrinho.length > 0) {
        carrinhoIcone.classList.add('carrinho-com-itens');
        
        // Atualiza o contador de itens
        if (contadorCarrinho) {
            contadorCarrinho.textContent = carrinho.reduce((acc, item) => acc + item.qtd, 0); // Soma as quantidades
            contadorCarrinho.style.display = 'inline-block';
        }
    } else {
        // Remove a animação e a cor verde se o carrinho estiver vazio
        carrinhoIcone.classList.remove('carrinho-com-itens');
        
        // Esconde o contador
        if (contadorCarrinho) {
            contadorCarrinho.style.display = 'none';
        }
    }
}

function diminuiQuantidade(id) {
    const produto = carrinho.find(item => item.id === id);
    if (produto && produto.qtd > 0) {
        produto.qtd--;
        if (produto.qtd === 0) {
            carrinho.splice(carrinho.indexOf(produto), 1); 
        }
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        renderizarCarrinho();
        atualizarCarrinho(); // Atualiza o ícone do carrinho após alteração
    }
}

function aumentarQuantidade(id) {
    const produto = carrinho.find(item => item.id === id);
    if (produto) {
        produto.qtd++;
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        renderizarCarrinho();
        atualizarCarrinho(); // Atualiza o ícone do carrinho após alteração
    }
}

// Função para alternar a visibilidade do carrinho
function ToggleCarrinho(){
    let cart = document.getElementById("carrinho");
    let carDisplay = cart.style.visibility;

    if(carDisplay === 'hidden'){
        cart.classList.add('visivel');
        cart.style.visibility = 'visible';
    }else{
        cart.classList.remove('visivel');
        cart.style.visibility = 'hidden';
    }
}

function realizarPedido() {
    const produtos = JSON.parse(localStorage.getItem('carrinho') || '[]');
    
    if (produtos.length === 0) {
        alert("O carrinho está vazio!");
        return;
    }

    // Formatar os produtos na estrutura esperada pelo PHP
    const produtosFormatados = produtos.map(produto => ({
        id_produto: produto.id,
        qtd_item: produto.qtd
    }));

    fetch('realizar_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            produtos: produtosFormatados
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(`Pedido realizado com sucesso! Número do pedido: ${data.nr_pedido}`);
            localStorage.removeItem('carrinho');
            renderizarCarrinho();
            atualizarCarrinho(); // Atualiza o carrinho após realizar o pedido
        } else {
            alert(`Erro: ${data.message}`);
            console.error(data.message);
        }
    })
    .catch(error => {
        alert("Erro ao realizar o pedido.");
        console.error(error);
    });
}

// Inicializa o estado do carrinho ao carregar a página
window.onload = function() {
    atualizarCarrinho(); // Atualiza o ícone e o contador ao carregar a página
}

