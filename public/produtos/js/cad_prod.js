$(document).ready(function () {

    let id = getParameterByName('val') ? getParameterByName('val') : getParameterByName('id');
    getCategorialist('');
    fillProdutos(id);
    $('#formProduto').submit(function(e){
        var productname = $('input[name="productname"]').val()
        var productdescription = $('input[name="productdescription"]').val()
        var productprice = parseFloat($('input[name="productprice"]').val());
        var optionscategoria = $('select[name="optionscategoria"]').val()

        if(isNaN(productprice)){
            alert("bota um numero macaco")
        }else{
            saveProd(id,productname,productdescription,productprice,optionscategoria)
        }

    });
    $('#botaodelete').on("click", function(){
        deleteProd(id);
    })
});


 function deleteProd(id){
    if(id == 0){
        e.preventDefault();
        alert("Não é possivel excluir algo que não existe!");
    }else{
        $.ajax({
            url: "../../app/src/produto/produto.php",
            dataType: 'json',
            type: "POST",
            headers: {
                'type' : 'delete_prod',
                'dados': id
            },
            success: function(response){
                console.log(response);
            },
            error: function(xhr){
                console.log(xhr);
            }
        })
    }
}

function getCategorialist(dados) {
    $.ajax({
        url: '../../app/src/categoria/categoria.php', 
        type: 'GET',
        headers: {
            'type': 'show_cat_expand',
            'dados': dados
        },
        success: function(response) {
            var categorias = response.data;

            var tbody = $('#optionscategoria');
            tbody.empty();

            categorias.forEach(function(categoria) {
                var row = `<option value="${categoria.id}">${categoria.descricao}</option>`;
                tbody.append(row);
            });
        },
        error: function(xhr) {
            console.error('Erro:', xhr.responseText);
        }
    });
}

function saveProd (id,productname,productdescription,productprice,optionscategoria){
        $.ajax({
            url: "../../app/src/produto/produto.php",
            dataType: 'json',
            type: "POST",
            headers: {
                'type' : 'cad_prod'
            },
            data: {
                id: id,
                productname: productname,
                productdescription: productdescription,
                productprice: productprice,
                optionscategoria: optionscategoria
            },
            success: function(data)
            {
                console.log(data);
                window.location.href = 'list_prod.php'
            },
            error: function(xhr, status, error) {
                console.log('Retorno: ' + error + status + xhr);
            }
        })
    
}

async function fillProdutos(id){
    if(id == 0){
        $('#botaodelete').hide();
    }else{
        await $.ajax({
            url: "../../app/src/produto/produto.php",
            type: 'GET',
            dataType: 'json',
            headers : {
                'type': 'teste',
                'id': id
            },
            success: function(data){
                dados = data.dados[0];
                var productname = $('input[name="productname"]');
                productname.val(dados.nome);
                var productdescription = $('input[name="productdescription"]');
                productdescription.val(dados.descricao);
                var productprice = $('input[name="productprice"]');
                productprice.val(dados.preco);
                var optionscategoria = $('select[name="optionscategoria"]');
                optionscategoria.val(dados.categoria);
            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        })
    }
}

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}