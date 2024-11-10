<?php

    

    include_once(__DIR__ . "/../../database/database.php");
    include_once(__DIR__ . "/../../public/gerais.php");
    include_once(__DIR__ . "/../../src/config/config_system.php");


    use \app\database\connect;
    use \app\public_\gerais;
    use \app\public_\seguranca;
    use \app\config\setting;


    $ger = new gerais();
    $bd = new connect();
    $sec = new seguranca();
    $setting = new setting();


    //$ger->doc_json();

    $json = null;

    @$usuario = $ger->getCookie("user_ck");
    @$senha = $ger->getCookie("senha_ck");

    

    if (!empty($usuario) && !empty($senha))
    {

        
        $usuario = $usuario;
        $senha = $sec->encryptString($senha,'md5');

        $query = "SELECT * FROM " . $setting::PREFIX_TABELAS . "usuarios WHERE usuario = '$usuario' and senha = '$senha'";

        $con_req = $bd->getQueryMysql($query);
        
        if ($con_req)
        {
            while($row = $con_req->fetch_assoc())
            {
                $nome_geral = $row['nome'];

            }
        }else
        {
            //$json = array("status" => "falha", "mensagem" => "Usuario ou Senha nao informado!", "usuario" => "$usuario", "senha" => "$senha");
            header("Location: ../login/index.php");
        }


    }else
    {
        //$json = array("status" => "falha", "mensagem" => "Usuario ou Senha nao informado!");

        

        header("Location: ../login/index.php");

    }


    //$ger->imprimir(json_encode($json,JSON_OBJECT_AS_ARRAY));









?>