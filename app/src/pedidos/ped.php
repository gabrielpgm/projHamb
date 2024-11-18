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


if ($metodo == "GET") {

    $dtinicio = isset($_GET['in']) ? $_GET['in'] : '2000-01-01';
    $dtfim = isset($_GET['fim']) ? $_GET['fim'] : '2050-01-01';

    $retorno = show_ped($dtinicio, $dtfim);
}


$ger->imprimir($retorno);





function show_ped($dtinicio, $dtfim)
{
    global $bd;

    $json = null;

    $query = "SELECT p.nr_pedido AS ped, 
                    pr.nome AS produto, 
                    p.qtd_item AS qtd, 
                    (p.qtd_item * pr.preco) AS valor,
                    p.data_pedido as dt
            FROM tb_pedidos p
            INNER JOIN tb_produtos pr ON pr.id = p.id_produto
            WHERE 
            p.data_pedido >= '$dtinicio 00:00:00' AND p.data_pedido <= '$dtfim 23:59:59'";

    $retorno = null;
    $produtos = array();

    $con = $bd->getQueryMysql($query);
    if ($con) {

        while ($row = $con->fetch_assoc()) {
            $produtos[] = array(
                "ped" => $row['ped'],
                "produto" => $row['produto'],
                "qtd" => $row['qtd'],
                "valor" => $row['valor'],
                "dt" => $row['dt']
            );
        }
        $retorno = array("code" => 200, "mensagem" => "Pedidos encontrados!", "retorno" => $bd->getCountMysql($con), "dados" => $produtos);
    } else {
        http_response_code(404);
        $json = array("code" => 404, "message" => "Pedidos não encontrados!");
    }

    // Retorna os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($retorno);
}
