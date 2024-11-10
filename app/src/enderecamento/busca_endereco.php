<?php

    include_once(__DIR__ . "/../../database/database.php");
    include_once(__DIR__ . "/../../public/gerais.php");
    include_once(__DIR__ . "/../access/check_access.php");
    include_once(__DIR__ . "/../../src/config/config_system.php");

    use app\database\connect;
    use app\public_\gerais;
    use \app\config\setting;

    
    $bd = new connect();
    $ger = new gerais();
    $setting = new setting();

    if(isset($_POST['endereco']))
    {
        $endereco = $_POST['endereco'];


        $query = "SELECT
        PROD.barra28 AS BARRA28,
        CONCAT(PROD.DESCRICAO, ' ', PROD.tam, ' ', PROD.desccor) AS DESCRICAO,
        BIP.CTG AS CTG,
        COUNT(BIP.CTG) AS CONTADOR
      FROM
        " . $setting::PREFIX_TABELAS . "prod_2 PROD
        INNER JOIN " . $setting::PREFIX_TABELAS . "bip BIP ON (BIP.ITEM = PROD.barra28 OR BIP.ITEM = PROD.barracli or BIP.ITEM = PROD.EAN13) and BIP.separado <> 1 and BIP.empresa = '$empresa_geral'
      WHERE
        PROD.barra28 = '$endereco' OR PROD.barracli = '$endereco' OR PROD.EAN13 = '$endereco' 
      GROUP BY
        BARRA28,
        DESCRICAO,
        CTG,
        PROD.tam,
        PROD.DESCCOR
        ORDER BY CONTADOR DESC";

        

        $con_endereco = $bd->getQueryMysql($query);

        if($con_endereco)
        {
            while($row = $con_endereco->fetch_assoc())
            {
                
                $ger->imprimir('<tr>');
                $ger->imprimir('<td>'.$row['DESCRICAO'].'</td>');
                $ger->imprimir('<td>'.$ctg = $row['CTG'].'</td>');
                $ger->imprimir('<td>'.$contador = $row['CONTADOR'].'</td>');
                $ger->imprimir('</tr>');

            }
        }else
        {
            $ger->imprimir('<tr>');
            $ger->imprimir('<td>Produto não encontrado!</td>');
            $ger->imprimir('</tr>');
        }
        


    }else
    {
        $ger->imprimir('<tr>');
        $ger->imprimir('<td>Produto não informado!</td>');
        $ger->imprimir('</tr>');

    }




?>