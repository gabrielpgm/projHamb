$(document).ready(function () {
    
});
function retornaDados(){



    $.ajax({
        url: '../../app/src/rfid/rfid.php?funcao=fila',
        type: 'GET',
        async: true,
        success: function(data){
            if (data.status === "success") {
                var items = data.retorno;
                var tbody = $('#tabelarfid tbody');
                tbody.empty(); 
                
                var disable = '';


                items.forEach(function(item) {
                    if (item.status === 'FALHA')
                    {
                        disable = '';
                    }else
                    {
                        disable = 'disabled';
                    }
                    var row = `<tr>
                        <td>${item.tipo}</td>
                        <td class="hidden-phone">${item.data}</td>
                        <td>${item.chave}</td>
                        <td>${item.serie}</td>
                        <td>${item.status}</td>
                        <td>${item.usuario}</td>
                        <td>      
                        <button ${disable} onclick="refresh(${item.id})" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i></button>
                        <button onclick="get_json(${item.id},'${item.chave}')"
                         class="btn btn-success btn-xs"  data-toggle="tooltip"
                          data-placement="top" title="ID de Movimento: ${item.id}"><i class="fa fa-cloud-download "></i></button>
                        </td>
                        <td></td>
                    </tr>`;
                    tbody.append(row);
                });
            
            }
        }
    });
    
}

function refresh(id)
{
    $.ajax({
        url: '../../app/src/rfid/rfid.php?funcao=refresh',
        type: 'POST',
        data: {id: id},
        beforeSend: function()
        {
            Swal.fire({
                title: 'Aguarde...',
                html: 'Enviando Documento.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                  Swal.showLoading(); 
                },
                showConfirmButton: false,
              });
        },
        success: function(data)
        {
            Swal.close();

            mensagem(data.status,data.mensagem);
            retornaDados();
        },
        error: function()
        {
            mensagem('error','Falha ao enviar documento para a Fila de Impressão!');
        }

    });
}


function get_json(id,chave)
{
    $.ajax({
        url: '../../app/src/rfid/rfid.php?funcao=json',
        type: 'POST',
        data: {id: id},
        beforeSend: function()
        {
            Swal.fire({
                title: 'Aguarde...',
                html: 'Baixando arquivo.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                  Swal.showLoading(); 
                },
                showConfirmButton: false,
              });
        },
        success: function(data)
        {
            Swal.close();

            var jsonStr = JSON.stringify(data);
            console.log(jsonStr);


            var blob = new Blob([jsonStr], { type: 'application/json' });

            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `documento_contare_${chave}(${id}).json`;
            document.body.appendChild(link);

            link.click();

            
            document.body.removeChild(link);
        },
        error: function()
        {
            mensagem('error','Falha ao Baixar o Arquivo Json!');
        }

    });
}




//${item.id}