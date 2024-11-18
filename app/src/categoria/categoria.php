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


//Declarações de variáveis
$setting = new setting();
$ger = new gerais();
$bd = new connect();
$headers = getallheaders();


$metodo = $_SERVER['REQUEST_METHOD'];
$json = null;


//INDENTIFICA QUE SERA DE RETORNO JSON A PÁGINA E JÁ FORMATA O ARQUIVO DE RETORNO
$ger->doc_json();




//AQUI IDENTIFICA O METODO DA PÁGINA

if ($metodo == "GET") {

    $tipo = isset($_GET['type']) ? $_GET['type'] : null;
    $tipeHeaders = isset($headers['type']) ? $headers['type'] : null;


    switch ($tipeHeaders) {
        case 'show_cat_only':
            //AQUI RETORNO O JSON DE UMA SÓ CATEGORIA
            $id = isset($_GET['id']) ? $_GET['id'] : null;

            if (is_null($id)) {
                http_response_code(405);
                $json = array("code" => 405, "message" => "Id não informado para busca!");
            } else {
                $json = get_cat_only($id);
            }
            break;
        case 'show_cat_expand':
            $dados = isset($headers['dados']) ? $headers['dados'] : null;
            $json = show_cat_expand($dados);
            break;
        default:
            break;
    }
} else if ($metodo == "POST") {

    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $descricao = isset($headers['descricao']) ? $headers['descricao'] : null;
    echo($id);
    echo($descricao);

    if (is_null($descricao)) {
        http_response_code(405);
        $json = array("code" => 405, "message" => "Campo obrigatorio (Descricao) nao informado");
    } else {
        $json = to_record_register($id, $descricao);
    }
} else if ($metodo == "DELETE") {

    $id = isset($headers['id']) ? $headers['id'] : null;

    if (is_null($id)){
        http_response_code(405);
        $json = array("code" => 405, "message" => "Id não informado para deletar!");
    } else {
        $json = get_cat_only($id);
    }
} else {

    //AQUI RETORNO ERRO 405 NA REQUISIÇÃO, QUER DIZER QUE NENHUMA REQUISIÇÃO FOI ENCONTRADA
    http_response_code(405);

    $json = array("code" => 405, "message" => "Método não encontrado na API.");
}




//imprimi o arquivo json
$ger->imprimir(json_encode($json, JSON_UNESCAPED_UNICODE ));






//Funções utilizadas 

function delete_cat($id)
{
    global $bd;

    $json = null;


    $query = "DELETE FROM tb_categoria WHERE id = ?";

    $parametros = [$id];

    $con = $bd->getSecureQueryMysql($query, $parametros, "i");

    if ($con) {
        http_response_code(200);
        $json = array("code" => 200, "message" => "Registro deletado!");
    }

    return $json;
}

function show_cat_expand($dados)
{
    global $bd;

    $json = null;

    try {

        $query = "SELECT * FROM tb_categoria ORDER BY descricao";

        $parametros = ["%$dados%"];

        $tipoParametro = 's'; //s significa string e i inteiro, para cada parametro tem que passar uma letra

        $con = $bd->getQueryMysql($query);
        

        if ($con){
            while ($row = $con -> fetch_assoc()){
                $categorias[] = array(
                    "id" => $row['id'],
                    "descricao" => $row['descricao']
                );}
            http_response_code(200);
            $json = array("code" => 200, "message" => "Busca realizada com sucesso!", "retorno" => $bd->getCountMysql($con) , "data" => $categorias);
        } else {
            http_response_code(404);
            $json = array("code" => 404, "message" => "Categoria não encontrada!");
        }
    } catch (\Throwable $th) {
        //throw $th;
        http_response_code(500);
        $json = array("code" => 500, "message" => "Erro encontrado na execução!", "data" => $th->getMessage());
    }

    return $json;
}


function to_record_register($id, $descricao)
{

    global $bd;

    $json = null;

    if (is_null($id) or $id == 0) {


        $query = "INSERT INTO tb_categoria (descricao) VALUES (?)";

        $parametros = [$descricao];

        $con = $bd->getSecureQueryMysql($query, $parametros, "i");


        if ($con) {
            http_response_code(201);
            $json = array("code" => 201, "message" => "Categoria criada com sucesso");
        } else {
            http_response_code(500);
            $json = array("code" => 500, "message" => "Erro ao criar categoria");
        }
    
    return $json;
    } else {

        $query = "UPDATE tb_categoria SET descricao = ? WHERE id = ? ";

        $parametros = [$descricao, $id];

        $con = $bd->getSecureQueryMysql($query, $parametros, "si");

        if ($con) {
            http_response_code(200);
            $json = array("code" => 200, "message" => "Categoria atualizada com sucesso");
        } else {
            http_response_code(500);
            $json = array("code" => 500, "message" => "Erro ao atualizar categoria");
        }
    }


    return $json;
}


function get_cat_only($id)
{
    global $bd;

    $json = null;

    try {

        $query = "SELECT * FROM tb_categoria WHERE id = ? ";

        $parametros = [$id];

        $tipoParametro = 'i'; //s significa string e i inteiro, para cada parametro tem que passar uma letra

        $con = $bd->getSecureQueryMysql($query, $parametros, $tipoParametro);

        if ($con) {
            http_response_code(200);
            $json = array("code" => 200, "message" => "Busca realizada com sucesso!", "data" => $con);
        } else {
            http_response_code(404);
            $json = array("code" => 404, "message" => "Categoria não encontrada!");
        }
    } catch (\Throwable $th) {
        //throw $th;
        http_response_code(500);
        $json = array("code" => 500, "message" => "Erro encontrado na execução!", "data" => $th->getMessage());
    }

    return $json;
}
