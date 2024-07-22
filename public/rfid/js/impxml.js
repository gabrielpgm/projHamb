
$(document).ready(function () {

    setInterval(returnXML,500);

    $('#arqxml').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '../../app/src/rfid/uploadxml.php?tipo=upload',
            type: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            beforeSend: function() {
                mensagem('success', 'Enviando arquivo XML');
            },
            success: function(data) {
                mensagem('success', data);
                
            },
            error: function() {
                mensagem('error', 'Erro ao enviar o arquivo XML');
            }
        });
    });

    


});



function returnXML(){
    $.ajax({
        url: '../../app/src/rfid/uploadxml.php?tipo=return',
        type: 'GET',
        success: function(data) {
            $('#tabelaArquivos tbody').html(data);
        },
        error: function() {
            mensagem('error', 'Erro ao puxar fila arquivo XML');
        }
    });
}

function processar(){
    $.ajax({
        url: '../../app/src/rfid/uploadxml.php?tipo=processa',
        type: 'GET',
        success: function(data) {
            mensagem(data.status,data.mensagem);
        },
        error: function() {
            mensagem('error', 'Erro ao puxar fila arquivo XML');
        }
    });
}

function limpar(){
    $.ajax({
        url: '../../app/src/rfid/uploadxml.php?tipo=limpa',
        type: 'GET',
        success: function(data) {
            mensagem(data.status,data.mensagem);
        },
        error: function() {
            mensagem('error', 'Erro ao puxar fila arquivo XML');
        }
    });
}