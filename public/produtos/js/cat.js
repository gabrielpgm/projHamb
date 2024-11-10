$(document).ready(function () {
        $('#formPesquisa').submit(function(e) {
        e.preventDefault();

       var descricao = $('input[name="descricao"]').val();
       gravar(descricao);     
    });  

    var id = getParameterByName("id");
    if(id != 0){
        retorna(id)
    }
});


function retorna(idR)
{
    console.log(idR);

    var endpoint = '../../app/src/categoria/categoria.php?type=show_cat_only&id=' + idR;

    console.log(endpoint);

    $.ajax({
        URL: endpoint,
        type: 'GET',
        success: function(Response){
           console.log(Response);
        },error: function(jqXHR, textStatus, errorThrown)
        {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            console.error("Resposta do servidor:", jqXHR.responseText);
        }

    })
    console.log(URL);
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
