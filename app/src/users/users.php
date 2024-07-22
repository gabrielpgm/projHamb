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

//Recebendo metodo Get
$metodo = $_GET['tipo'];
$retorno = null;

$ger->doc_json();

switch ($metodo) {
    case 'show':
        $dados = $_POST['dados'];
        $retorno = showUser($dados);
        break;
    default:
        # code...
        break;
}

$ger->imprimir(json_encode($retorno));

function showUser($dados)
{


    global $setting;
    $bd = new connect();

    $query = "SELECT * FROM " . $setting::PREFIX_TABELAS . "acesso WHERE NOME LIKE '%$dados%' ORDER BY EMPRESA,NOME";


    $con = $bd->getQueryMysql($query);

    $retorno = null;
    $usuarios = array();

    if ($con) {

        while ($row = $con->fetch_assoc()) {
            $usuarios[] = array(
                "id" => $row['ID'],
                "nome" => $row['NOME'],
                "usuario" => $row['USUARIO'],
                "token" => $row['SENHA'],
                "permissao" => $row['PERMISSAO'],
                "ultevento" => $row['LOG'],
                "ativo" => $row['ATIVO'],
                "empresa" => $row['EMPRESA']
            );
        }

        $retorno = array("code" => 200, "mensagem" => "Usuários encontrados!","retorno" => $bd->getCountMysql($con), "dados" => $usuarios);
    } else {
        $retorno = array("code" => 401, "mensagem" => "Sem dados", "dados" => $usuarios);
    }

    return $retorno;
}
