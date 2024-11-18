$(document).ready(function () {
        $('#formPesquisa').submit(function(e) {
        e.preventDefault();

       var descricao = $('input[name="descricao"]').val();
       gravar(descricao);     
    });  

    var id = getParameterByName("id");
    if(id != 0){
        retorna(id);
    }
});



function retorna(id) {
    $.ajax({
        url: '../../app/src/categoria/categoria.php?type=show_cat_only&id=' + id,
        type: 'GET',
        dataType: 'json', 
        headers: {
            'Accept': 'application/json' 
        },
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


function gravar(descricao)
{
      $.ajax({
        URL:'../../app/src/categoria/categoria.php',
        type: 'POST',
        dataType: 'json',
        headers: {
            'type': 'cad_cat',
            'descricao': descricao
        }, sucess: function (response){
            console.log(response);
        }, error: function(xhr){
            console.log(xhr);
        }
    })

}

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
