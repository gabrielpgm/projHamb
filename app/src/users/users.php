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
$metodo = $_GET['tipo'];
$retorno = null;

$ger->doc_json();

switch ($metodo) {
    case 'show':
        $dados = @$_POST['dados'];
        $retorno = showUser($dados);
        break;
    case 'show_user_detail':
        $dados = @$_POST['dados'];
        $retorno = showUserDetail($dados);
        break;
    case 'gred_dados':
        $dados = @$_POST['dados'];
        $usuario = @$_POST['usuario'];
        $nome = @$_POST['nome'];
        $senha = @$_POST['senha'];
        $retorno = gred_dados($dados, $usuario, $nome, $senha);
        break;
    default:
        # code...
        break;
}

$ger->imprimir($retorno);


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

function showUserDetail($code)
{
    global $setting;
    $bd = new connect();

    $query = "SELECT * FROM " . $setting::PREFIX_TABELAS . "usuarios WHERE id = '$code'";

    $con = $bd->getQueryMysql($query);

    if ($con) {
        $row = $con->fetch_assoc();


        $retorno = array(
            "id" => $row['id'],
            "nome" => $row['nome'],
            "senha" => $row['senha'],
            "usuario" => $row['usuario']
        );

        $retorno = json_encode($retorno);
        return $retorno;
    }
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
