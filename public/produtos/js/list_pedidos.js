$(document).ready(function () {
    // Definir o dia de hoje como valor padrão nos campos de data
    var hoje = new Date();
    var dataFormatada = hoje.toISOString().split('T')[0]; // Formato yyyy-mm-dd

    // Definir o valor dos campos de data
    $('#data_inicio').val(dataFormatada); // Data início com o dia de hoje
    $('#data_fim').val(dataFormatada); // Data fim com o dia de hoje

    // Carregar os pedidos com o intervalo de data padrão
    getCatExpand(dataFormatada, dataFormatada);

    // Chamada ao enviar o formulário
    $('#formPesquisa').submit(function(e) {
        e.preventDefault();
        var ini = $('input[name="data_inicio"]').val();
        var fim = $('input[name="data_fim"]').val();
        getCatExpand(ini, fim);
    });
});

// Função que faz o AJAX e preenche a página com os pedidos
function getCatExpand(ini, fim) {
    $.ajax({
        url: '../../app/src/pedidos/ped.php?in=' + ini + '&fim=' + fim,
        type: 'GET',
        success: function(response) {
            console.log(response); // Verifique se a resposta está correta no console

            var pedidos = response.dados;
            var pedidosContainer = $('#pedidosContainer');
            pedidosContainer.empty(); // Limpa os pedidos anteriores

            // Agrupar os pedidos por número de pedido
            var pedidosAgrupados = {};

            pedidos.forEach(function(pedido) {
                if (!pedidosAgrupados[pedido.ped]) {
                    pedidosAgrupados[pedido.ped] = {
                        ped: pedido.ped,
                        produtos: [],
                        total: 0,
                        data: pedido.dt
                    };
                }

                // Adiciona o produto ao pedido agrupado
                pedidosAgrupados[pedido.ped].produtos.push({
                    produto: pedido.produto,
                    qtd: pedido.qtd,
                    valor: parseFloat(pedido.valor)
                });

                // Soma o valor total do pedido
                pedidosAgrupados[pedido.ped].total += parseFloat(pedido.valor);
            });

            // Gerar HTML para os pedidos agrupados
            for (var ped in pedidosAgrupados) {
                var pedido = pedidosAgrupados[ped];
                var produtosHTML = '';

                // Gerar HTML para os produtos
                pedido.produtos.forEach(function(produto) {
                    produtosHTML += `
                    <div class="produto-item">
                        <span class="produto-descricao"><strong>${produto.qtd} x</strong> ${produto.produto}</span>
                        <span class="produto-valor">R$ ${produto.valor.toFixed(2)}</span>
                    </div>
                `;


                });

                // Gerar HTML do pedido
                var pedidoHTML = `
                    <div class="pedido-block col-lg-4 col-md-6 col-sm-12">
                        <div class="pedido-card">
                            <p class="pedido-data"><strong>Data:</strong> ${pedido.data}</p>
                            <h4 class="pedido-nr">Pedido: ${pedido.ped}</h4>
                            <ul class="produtos">
                                ${produtosHTML}
                            </ul>
                            <p class="pedido-total"><strong>Total:</strong> R$ ${pedido.total.toFixed(2)}</p>
                        </div>
                    </div>

                `;
                pedidosContainer.append(pedidoHTML); // Adiciona o pedido à página
            }
        },
        error: function(xhr) {
            console.error('Erro:', xhr.responseText);
        }
    });
}
