<?php

    include_once(__DIR__ . "/../../database/database.php");
    include_once(__DIR__ . "/../../public/gerais.php");
    include_once(__DIR__ . "/../access/check_access.php");

    use app\database\connect;
    use app\public_\gerais;

    
    $bd = new connect();
    $ger = new gerais();

    if(isset($_POST['endereco']))
    {
        $endereco = $_POST['endereco'];


        $query = "SELECT *
                    FROM " . $setting::PREFIX_TABELAS . "local 
                    WHERE id LIKE '%$endereco%'
                    AND empresa = '$empresa_geral'
        ";

       

        $con_endereco = $bd->getQueryMysql($query);

        if($con_endereco)
        {
            while($row = $con_endereco->fetch_assoc())
            {
                
                $ger->imprimir('<tr>');
                $ger->imprimir('<td>'.$row['id'].'</td>');
                $ger->imprimir('<td>');
                $ger->imprimir('<form action="enderecamento.php" method="post">');
                $ger->imprimir('<input type="hidden" name = "endereco" value = "'.$row['id'].'" />');
                $ger->imprimir('<button type = "submit"  class = "btn btn-theme" >Endereçar</button>');
                $ger->imprimir('</form>');
                $ger->imprimir('</td>');
                $ger->imprimir('</tr>');

            }
        }else
        {
            $ger->imprimir('<tr>');
            $ger->imprimir('<td>Local não encontrado!</td>');
            $ger->imprimir('</tr>');
        }
        


    }else
    {
        $ger->imprimir('<tr>');
        $ger->imprimir('<td>Produto não informado!</td>');
        $ger->imprimir('</tr>');

    }




?>