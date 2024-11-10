


$(document).ready(function () {
    rtr();
    setInterval(retornaSincronia, 500);
    $('#formPesquisa').submit(function (e) {
        e.preventDefault();
        gravar();
    });
});


function gravar()
{
    
    var inventario = $("input[name='inventario']").val();
    var timeout = $("input[name='timeout']").val();

    $.ajax({
        type: 'POST',
        url: '../../app/src/config/config.php?funcao=insert',
        data: {
            inventario: inventario,
            timeout: timeout
        },
        success: function(data){
            mensagem(data.status,data.mensagem);
        },error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            console.error("Resposta do servidor:", jqXHR.responseText);
        }
    });
}

function rtr() {
    $.ajax({
        url: '../../app/src/config/config.php?funcao=show',
        method: 'GET',
        dataType: 'json',
        beforeSend: function(){
            Swal.fire({
                title: 'Aguarde...',
                html: 'Buscando dados.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                  Swal.showLoading(); 
                },
                showConfirmButton: false,
              });
        },
        success: function(data) {
            Swal.close();
            if (data.status === "success") {
                var iventatual = data.dados.inventatual;
                var timeout = data.dados.horasincronia;
                var pathdoc = data.dados.pathdoc;
    
                $("input[name='inventario']").val(iventatual);
                $("input[name='timeout']").val(timeout);
                $("input[name='logsdoc']").val(pathdoc);
                
            } else {
                console.log("Erro ao recuperar dados:", data.mensagem);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('chegou aqui erro requisicao');
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            console.error("Resposta do servidor:", jqXHR.responseText);
        }
    });
}


function retornaSincronia()
{   
    const progressBar = document.querySelector('.progress-bar');
    $.ajax({
        type: 'GET',
        url: '../../app/src/sincroniza/mensagem.txt',
        success: function (data) {
            $('#produto_atual').text('Progresso de Sincronização: ' + data);

            
        }
    });
    $.ajax({
        url: '../../app/src/sincroniza/progress.json',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var progress = data.progress.toFixed(2);
            if (progress == 100)
            {
                progressBar.style.width = '0%';

            }else
            {
                progressBar.style.width = progress + '%';
            }
            
        },
        error: function () {
            setTimeout(checkProgress, 500);
            console.log("Erro"); 
        }
    });
}

