$(document).ready(function () {

    var usuario = getParameterByName('id');
    

    if (usuario != 0 && usuario != null) {

        retornUserId(usuario);
    }

});

function retornaNivel(usuario)
{
    $.ajax({
        url: "../../app/src/users/users.php?tipo=show_lib",
        type: "POST",
        data: {
            dados: usuario
        },
        async: true,
        success: function(data) {
            $('#permissao').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            console.error("Resposta do servidor:", jqXHR.responseText);
        }
    });
}

function retornUserId(usuario) {
    
    $.ajax({
        url: '../../app/src/users/users.php?tipo=show_user_detail',
        type: "POST",
        data: {
            dados: usuario
        },
        dataType: 'json',
        async: true,
        success: function(data) {
            $('input[name="nome"]').val(data.nome);
            $('input[name="senha"]').val(data.senha);
            $('input[name="usuario"]').val(data.usuario);
        },
        error: function(xhr, status, error) {
            console.log('Erro no AJAX: ' + error);
        }
    });
}


function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}