<?php

    date_default_timezone_set('America/Sao_Paulo');

    include_once(__DIR__ . "/../../database/database.php");
    include_once(__DIR__ . "/../../public/gerais.php");
    include_once(__DIR__ . "/../config/config_system.php");

    use app\config\setting;
    use app\database\connect;   
    use app\public_\gerais;

    $bd = new connect();
    $ger = new gerais();
    $setting = new setting();


    $retorno = null;


    if(isset($_GET['funcao']))
    {

        $funcao = $_GET['funcao'];

        if(isset($_POST['endereco']))
        {
            $endereco = $_POST['endereco'];
            $item = isset($_POST['item']) ?  $_POST['item'] : 0;


            switch ($funcao) {
                case 'contador':
                    retorna_contagem($endereco);
                    break;
                case 'endereco';
                    retorna_endereco($endereco);
                    break;
                case 'inseri';
                    inserir_registro($endereco,$item);
                    break;
                default:
                    break;
            }


        }else
        {
            echo "Endereço não informado!";
        }
    }else
    {
        echo "Erro: Função não definida!";
    }



    function inserir_registro($endereco,$item)
    {
        
        

        include_once(__DIR__ . "/../access/check_access.php");

        //Todas as vezes que chama esta função já fala para o navegador que estou retornando um JSON.
        $ger->doc_json();

        $json = null;

        $query = "SELECT 
        PROD.ARTIGO AS ARTIGO, 
        PROD.DESCRICAO AS DESCRICAO,
        PROD.cor AS COR, 
        PROD.DESCCOR AS DESCCOR,
        PROD.TAM AS TAM
        FROM " . setting::PREFIX_TABELAS . "prod_2 AS PROD
        WHERE 
        PROD.BARRA28 = '$item' OR PROD.BARRACLI = '$item' OR PROD.EAN13 = '$item' 
        LIMIT 1";

        $conn = $bd->getQueryMysql($query);
        $conn_num = $bd->getCountMysql($conn);

        if($conn_num > 0)
        {
            $row = $conn->fetch_assoc();

            $descricao = $row['DESCRICAO'];
            $tam = $row['TAM'];
            $desccor = $row['DESCCOR'];
            $cor = $row['COR'];
            $dataatual = date('Y-m-d H:i:s');

            $query = "INSERT INTO " . setting::PREFIX_TABELAS . "bip (ITEM,CTG,DESCITEM,TAM,COR,DESCOR,USUARIO,EMPRESA,`DATA`) VALUES
            ('$item','$endereco','$descricao','$tam','$cor','$desccor','$usuario_geral','$empresa_geral','$dataatual')";

            $con = $bd->getQueryMysql($query);

            if($con)
            {
                $json = array("status"=> "success","mensagem" => "Registro Inserido!");
            }else
            {
                $json = array("status"=> "error","mensagem" => "Falha ao inserir registro!");
            }

        }else
        {
            $json = array("status"=> "error","mensagem" => "Produto não encontrado");
        }

        $ger->imprimir(json_encode($json,JSON_OBJECT_AS_ARRAY));

    }

    function retorna_endereco($endereco)
    {
        include_once(__DIR__ . "/../access/check_access.php");

        $query = "SELECT * FROM " . setting::PREFIX_TABELAS . "bip WHERE CTG = '$endereco' AND separado <> 1 AND empresa = '$empresa_geral' ORDER BY ID DESC";

        $con = $bd->getQueryMysql($query);
        $con_num = $bd->getCountMysql($con);

        if($con_num > 0)
        {
            while($row = $con->fetch_assoc())
            {
                $ger->imprimir('<tr>');
                $ger->imprimir('<td class="numeric">'.$row['ID'].'</td>');
                $ger->imprimir('<td class="numeric">'.$row['ITEM'].'</td>');
                $ger->imprimir('<td>'.$row['DESCITEM'].'</td>');
                $ger->imprimir('<td>'.$row['TAM'].'</td>');
                $ger->imprimir('<td>'.$row['DESCOR'].'</td>');
                $ger->imprimir('<td>'.$row['CTG'].'</td>');
                $ger->imprimir('<tr>');
            }
            
        }else
        {
            echo "";
        }
    }

    function retorna_contagem($endereco)
    {

        include_once(__DIR__ . "/../access/check_access.php");

        $query = "SELECT COUNT(*) AS contador 
        FROM " . setting::PREFIX_TABELAS . "bip b
        WHERE 
        b.CTG = '$endereco' AND b.separado <> 1 AND b.empresa = '$empresa_geral'";


        $con = $bd->getQueryMysql($query);
        $con_num = $bd->getCountMysql($con);

        if($con_num > 0)
        {
            $retorno = $con->fetch_assoc();
            echo "Contagem Atual:" . $retorno['contador'];
        }else
        {
            echo "Contagem Atual: 0";
        }

    }


?>