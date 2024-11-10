$(document).ready(function () {
    getProdutoLista('');
    $('#formPesquisa').submit(function(e) {
        e.preventDefault();

       var nome = $('input[name="chave"]').val();
       getCatExpand(nome);
    });  
});




async function getProdutoLista(dados) {
    await $.ajax({
        url: '../../app/src/produto/produto.php', 
        type: 'GET',
        headers: {
            'type': 'show_produtos',
            'dados': dados
        },
        success: function(response) {           
            produtos = response.dados;
            var tbody = $('#tabelaProdutos tbody');
            tbody.empty();
            produtos.forEach(function(produtos) {
                 var row = `<tr>
                             <td>${produtos.nome}</td>
                             <td>${produtos.descricao}</td>
                             <td>${produtos.categoria}</td>
                             <td>R$${produtos.preco}</td>
                             <td>
                             <a href="cad_prod.php?id=${produtos.id}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                             </td>
                             </tr>`;
                 tbody.append(row);
            });
        },
        error: function(xhr) {
            console.error('Erro:', xhr.responseText);
        }
    });
}
