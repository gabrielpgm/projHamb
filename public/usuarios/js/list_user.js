$(document).ready(function () {
    retornaDados('');
    $('#formPesquisa').submit(function(e) {
        e.preventDefault();

       var nome = $('input[name="chave"]').val();
       retornaDados(nome);
    });  
});





function retornaDados(nome){

    

    $.ajax({
        url: "../../app/src/users/users.php?tipo=show",
        type: "POST",
        data:{
            dados: nome
        },
        async: true,
        success: function(data){
            if (data.code === 200)
            {
                var items = data.dados;
                var tbody = $('#tabelaUsuarios tbody');

                tbody.empty();

                items.forEach(function(item) {


                    var row = `<tr>
                        <td>${item.id}</td>
                        <td class="hidden-phone">${item.usuario}</td>
                        <td>${item.nome}</td>
                        <td>
                        <a href="user.php?id=${item.id}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                        </td>
                        <td></td>
                    </tr>`;
                    tbody.append(row);
                });

                
            }
        },error: function(jqXHR, textStatus, errorThrown)
        {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            console.error("Resposta do servidor:", jqXHR.responseText);
        }


    });
}