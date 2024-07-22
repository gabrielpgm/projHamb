<?php


    include_once(__DIR__ . "/../../database/database.php");
    include_once(__DIR__ . "/../../public/gerais.php");
    include_once(__DIR__ . "/config_system.php");
    include_once(__DIR__ . "/../access/check_access.php");


    use app\config\setting;
    use app\database\connect;   
    use app\public_\gerais;

    $bd = new connect();
    $ger = new gerais();
    $setting = new setting();


    $empresasys = $empresa_geral;

    $ger->doc_json();
    $json = null;

    if(isset($_GET['funcao']))
    {
        $funcao = $_GET['funcao'];


        //Carrega POST 
        $inventario = isset($_POST['inventario']) ? $_POST['inventario'] : null;
        $timeout = isset($_POST['timeout']) ? $_POST['timeout'] : null;

        //Faz seleção da função enviada
        switch ($funcao) {
            case 'insert':
                $json = insert($inventario,$timeout);
                break;
            case 'show':
                $json = show();
                break;
            default:
                $json = array("status" => "error", "mensagem" => "funcao nao encontrada");
                break;
        }

    }else
    {
        $json = array("status" => "error", "mensagem" => "funcao nao informada");
    }


    $ger->imprimir(json_encode($json));


//FUNÇÕES PARA CADA TRATATIVA DO FONTE

    function insert($inventario,$timeout)
    {
        //Variaveis Instanciadas anteriormente e declaradas como globais
        global $setting;
        global $bd;
        global $empresasys;

        //Variaveis de Retorno
        $json = null;

        $query = "SELECT * FROM " . $setting::PREFIX_TABELAS . "config WHERE empresa = '$empresasys'";

        $result = $bd->getQueryMysql($query);
        $result_num = $bd->getCountMysql($result);


        if ($result_num == 0)
        {


            //INSERI REGISTRO CASO NÃO EXISTA REGISTRO DE CONFIGURAÇÃO
            $query = "INSERT INTO " . $setting::PREFIX_TABELAS . "config (invetatual,
            horasincronia,empresa) VALUES ('$inventario','$timeout','$empresasys')";

            $conn = $bd->getQueryMysql($query);
            if ($conn) {
                $json = array("status" => "success", "mensagem" => "Configurões Inseriadas com sucesso!");
            }else{
                $json = array("status" => "error", "mensagem" => "Falha ao gravar registro.");
            }

        }else
        {

            //ALTERAR O REGISTRO JA EXISTENTE MEDIANTE A EMPRESA DO USUÁRIO LOGADO
            $query = "UPDATE " . $setting::PREFIX_TABELAS . "config SET 
            invetatual = '$inventario', horasincronia = '$timeout' WHERE empresa = '$empresasys'";

            $conn = $bd->getQueryMysql($query);
            if ($conn) {
                $json = array("status" => "success", "mensagem" => "Configurões Alterada com sucesso!");
            }else{
                $json = array("status" => "error", "mensagem" => "Falha ao editar registro.");
            }

        }

        return $json;
    }


    function show()
    {

        global $bd;
        global $empresasys;
        global $setting;

        $query = "SELECT * FROM " . $setting::PREFIX_TABELAS . "config WHERE empresa = '$empresasys'";
        $result = $bd->getQueryMysql($query);
        $result_num = $bd->getCountMysql($result);

        if($result_num > 0)
        {
            $row = $result->fetch_assoc();

            $json = array("status" => "success", "mensagem" => "Configurações Resgatatas", 
            "dados" => array("inventatual" => $row['invetatual'], "horasincronia" => $row['horasincronia'],"pathdoc" => $row['pathdoc']));

            return $json;

        }


    }


?>