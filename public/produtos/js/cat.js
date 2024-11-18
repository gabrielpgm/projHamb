$(document).ready(function () {
   
    $('#formPesquisa').submit(function(e) {
        e.preventDefault();

        // Captura o valor da descrição
        var descricao = $('input[name="descricao"]').val();
        
        // Chama a função para gravar
        gravar(descricao);     
    });

    // Verifica se há um 'id' na URL (edição de categoria)
    var id = getParameterByName("id");
    if (id != 0) {
        retorna(id);
    }
});

function retorna(id) {
    $.ajax({
        url: '../../app/src/categoria/categoria.php?type=show_cat_only&id=' + id, // Requisição GET
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            console.log(response.data[0].descricao);
            $('input[name="descricao"]').val(response.data[0].descricao);
        },
        error: function(xhr, status, error) {
            console.error("Erro na requisição:", error); 
            console.error("Status:", status);
            console.error("Resposta completa:", xhr.responseText); 
        }
    });
}

function gravar(descricao) {
    $.ajax({
        url: '../../app/src/categoria/categoria.php', // Requisição POST
        type: 'POST',
        dataType: 'json',
        data: { // Envia os dados no corpo da requisição
            type: 'cad_cat',
            descricao: descricao
        },
        success: function(response) {
            console.log("Categoria registrada:", response);
            // Adicione aqui algum comportamento, como limpar o campo ou mostrar uma mensagem
        },
        error: function(xhr, status, error) {
            console.error("Erro ao gravar a categoria:", error);
            console.error("Status:", status);
            console.error("Resposta completa:", xhr.responseText);
        }
    });
}

// Função para pegar parâmetros da URL (ex: ?id=123)
function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
