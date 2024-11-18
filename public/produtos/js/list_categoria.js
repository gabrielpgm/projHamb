$(document).ready(function () {
    getCatExpand('');
    $('#formPesquisa').submit(function(e) {
        e.preventDefault();

       var nome = $('input[name="chave"]').val();
       getCatExpand(nome);
    });  
});




function getCatExpand(dados) {
    $.ajax({
        url: '../../app/src/categoria/categoria.php?type=show_cat_expand', 
        type: 'GET',
        headers: {
            'dados': dados,
            'Accept': 'application/json',
            'type':'show_cat_expand'
        },
        success: function(response) {
            console.log(response);
            var categorias = response.data;

            var tbody = $('#tabelaCategorias tbody');
            tbody.empty();

            categorias.forEach(function(categoria) {
                var row = `<tr>
                            <td>${categoria.id}</td>
                            <td>${categoria.descricao}</td>
                            <td>
                            <a href="cat.php?id=${categoria.id}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
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