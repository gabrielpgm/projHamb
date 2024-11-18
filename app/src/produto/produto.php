<?php

//Inclusão dos Arquivos dependentes
include_once(__DIR__ . "/../../database/database.php");
include_once(__DIR__ . "/../../public/gerais.php");
include_once(__DIR__ . "/../config/config_system.php");

//Chamando Namespaces

use app\database\connect;
use app\src\theme\construct_theme;
use app\public_\gerais;
use app\config\setting;

$setting = new setting();
$ger = new gerais();
$bd = new connect();

//Recebendo metodo Get
$metodo = $_SERVER['REQUEST_METHOD'];
$retorno = null;

$headers = getallheaders();
$tipo = isset($headers['type']) ? $headers['type'] : null;
$dados = isset($headers['dados']) ? $headers['dados'] : null;

$ger->doc_json();


if($metodo == "GET"){

    switch ($tipo) {
        case 'show_produtos':
            $retorno = show_prod($dados);
            break;
        case 'teste':
            $id = isset($headers['id']) ? $headers['id'] : null ;
            $retorno = produtobyid($id);
            break;
        default:
            $retorno = $tipo;
            break;
            }
}else if($metodo == "POST"){

    switch ($tipo) {
        case 'cad_prod': 
            $id = @$_POST['id'];
            $productname = @$_POST['productname'];
            $productdescription = @$_POST['productdescription'];
            $productprice = @$_POST['productprice'];
            $optionscategoria = @$_POST['optionscategoria'];
            
            // Aqui, passamos $_FILES['imagem'] em vez de $_POST['imagem']
            $imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : null; 
            
            $retorno = cad_prod($id, $productname, $productdescription, $productprice, $optionscategoria, $imagem);
            break; 
        case 'delete_prod':
            $retorno = delete_prod($dados);
            break;
        default:
            $retorno = $tipo;
            break;
    }
}



$ger->imprimir($retorno);

function delete_prod($id){

    global $setting;
    $bd = new connect();


    $query = "DELETE FROM " . $setting::PREFIX_TABELAS . "produtos where id in ('$id')";

    $con = $bd->getQueryMysql($query);

    if ($con) {
        $retorno = array('code' => 200, 'msg' => 'Produto excluido com sucesso');
        $retorno = json_encode($retorno);
        return $retorno;
    }

}

function gred_dados($id, $usuario, $nome, $senha)
{

    global $setting;
    $bd = new connect();


    $query = null;


    if ($id > 0) {
        $senha = md5($senha);
        $query = "UPDATE " . $setting::PREFIX_TABELAS . "usuarios SET nome = '$nome', senha = '$senha' WHERE id = '$id' ";
    } else {
        $senha = md5($senha);
        $query = "INSERT INTO " . $setting::PREFIX_TABELAS . "usuarios (usuario,senha,nome) VALUES ('$usuario','$senha','$nome')";
    }

    $con = $bd->getQueryMysql($query);

    if ($con) {
        $retorno = array('code' => 200, 'msg' => 'Dados atualizados');
        $retorno = json_encode($retorno);
        return $retorno;
    }
}
function cad_prod($id, $productname, $productdescription, $productprice, $optionscategoria, $imagem){
    global $setting;
    $bd = new connect();

    // Pasta para armazenar a imagem
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/";

    // Verifica se o diretório existe, caso contrário, cria
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Definindo as extensões válidas
    $validExtensions = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

    // Verificando se a extensão é válida
    if (!in_array($ext, $validExtensions)) {
        return json_encode(array('code' => 400, 'msg' => 'Formato de imagem não permitido.'));
    }

    // Verifica se uma imagem foi enviada com sucesso
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagemNome = uniqid('img_') . '.' . pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagemPath = $uploadDir . $imagemNome;
    
        // Verifique se o arquivo foi movido corretamente
        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
            error_log("Erro ao mover a imagem para a pasta de uploads: " . $_FILES['imagem']['error']);
        } else {
            error_log("Imagem salva com sucesso: " . $imagemPath);
        }
    } else {
        error_log("Erro no upload da imagem: " . $_FILES['imagem']['error']);
    }
    
    
    // Verifique se o ID é 0 (novo produto) ou se está fazendo atualização
    if ($id == 0) {
        // Inserir novo produto
        $query = "INSERT INTO " . $setting::PREFIX_TABELAS . "produtos (nome, descricao, preco, categoria, imagem) 
                  VALUES ('$productname', '$productdescription', '$productprice', '$optionscategoria', '$imagemNome')";
        $con = $bd->getQueryMysql($query);
    } else {
        // Atualizar produto existente
        $query = "UPDATE " . $setting::PREFIX_TABELAS . "produtos 
                  SET descricao = '$productdescription', imagem = '$imagemNome', nome = '$productname', preco = '$productprice', categoria = '$optionscategoria' 
                  WHERE id = '$id'";
        $con = $bd->getQueryMysql($query);
    }

    if ($con) {
        return json_encode(array('code' => 200, 'msg' => 'Produto salvo com sucesso.'));
    } else {
        return json_encode(array('code' => 500, 'msg' => 'Erro ao salvar produto.'));
    }
}






function show_prod($dados){
    global $bd;

    $json = null;

    $query = "SELECT produtos.id as id, produtos.nome as nome, produtos.descricao as descricao, produtos.preco as preco, cat.descricao as categoria FROM tb_produtos produtos inner join tb_categoria cat on (produtos.categoria = cat.id) order by produtos.nome";

    $retorno = null;
    $produtos = array();

    $con = $bd->getQueryMysql($query);
         if ($con) {
        
           while( $row = $con->fetch_assoc()){
              $produtos[] = array(
                  "id" => $row['id'],
                  "nome" => $row['nome'],
                  "descricao" => $row['descricao'],
                  "preco" => $row['preco'],
                  "categoria" => $row['categoria']
                );
            }
            $retorno = array("code" => 200, "mensagem" => "Usuários encontrados!", "retorno" => $bd->getCountMysql($con), "dados" => $produtos);
            
        } else {
            http_response_code(404);
            $json = array("code" => 404, "message" => "Categoria não encontrada!");
        }
    
    // Retorna os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($retorno);

}

function produtobyid($dados){
    global $bd;

    $json = null;

    $query = "SELECT * FROM tb_produtos where id in ('$dados') order by nome";

    $retorno = null;
    $produtos = null;

    $con = $bd->getQueryMysql($query);
         if ($con) {
            $row = $con->fetch_assoc();
           
              $produtos[] = array(
                  "id" => $row['id'],
                  "nome" => $row['nome'],
                  "descricao" => $row['descricao'],
                  "preco" => $row['preco'],
                  "categoria" => $row['categoria']
                );
            
            $retorno = array("code" => 200, "mensagem" => "Usuários encontrados!", "retorno" => $bd->getCountMysql($con), "dados" => $produtos);
            
        } else {
            http_response_code(404);
            $json = array("code" => 404, "message" => "Categoria não encontrada!");
        }
    
    // Retorna os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($retorno);

}

function showUser($dados)
{
    global $setting;
    $bd = new connect();

    $query = "SELECT * FROM " . $setting::PREFIX_TABELAS . "usuarios WHERE nome LIKE '%$dados%' ORDER BY nome";


    $con = $bd->getQueryMysql($query);

    $retorno = null;
    $usuarios = array();

    if ($con) {
        while ($row = $con->fetch_assoc()) {
            $usuarios[] = array(
                "id" => $row['id'],
                "nome" => $row['nome'],
                "usuario" => $row['usuario']
            );
        }

        $retorno = array("code" => 200, "mensagem" => "Usuários encontrados!", "retorno" => $bd->getCountMysql($con), "dados" => $usuarios);
    } else {
        $retorno = array("code" => 401, "mensagem" => "Sem dados", "dados" => $usuarios);
    }

    // Retorna os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($retorno);
}
