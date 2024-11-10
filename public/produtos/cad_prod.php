<?php

include_once(__DIR__ . "/../../app/src/theme/construct.php");
include_once(__DIR__ . "/../../app/public/gerais.php");



use app\src\theme\construct_theme;
use app\public_\gerais;

$theme = new construct_theme();

$theme->construct_head();

$ger = new gerais();

$ger->imprimir('<body>');
$ger->imprimir('<section id="container">');




$theme->construct_menu();


$ger->imprimir('
    <section id="main-content">
      <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-12">
            <h4><i class="fa fa-angle-right"></i> Cadastro de Produtos</h4>
            
            <div class="form-panel">
                <form id="formProduto" role="form" class="form-horizontal style-form" action="javascript:void(0);">

                <div class="container">
                    <div class="form-group has-success">
                        <label class="col-lg-2 control-label">Nome</label>
                        <div class="col-lg-10">
                        <input type="text" placeholder="" id="f-name" name = "productname" class="form-control" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="form-group has-success">
                        <label class="col-lg-2 control-label">Descrição</label>
                        <div class="col-lg-10">
                        <input type="text" placeholder="" id="f-name" name = "productdescription" class="form-control" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="form-group has-success">
                        <label class="col-lg-2 control-label">Categoria</label>
                        <div class="col-lg-10">
                            <select class="form-control" id="optionscategoria" name="optionscategoria">
                        </select>
                        
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="form-group has-success">
                        <label class="col-lg-2 control-label">Preço</label>
                        <div class="col-lg-10">
                        <input type="text" placeholder="" id="f-name" name = "productprice" class="form-control" required autofocus>
                        </div>
                    </div>
                </div>

                <div class="form-group d-flex align-items-center justify-content-center col-6">
                    <div class="col-lg-offset-1">
                    <a href="list_prod.php"><button class="btn btn-theme" type="submit">Gravar</button></a>
                    <a href="list_prod.php"><button class="btn btn-danger d-none" id="botaodelete">Excluir</button></a>
                    </div>
                </div>
                </form>
                
                

            </div>
            </div>
        
        </div>
       </section>
    </section>
    
    ');



$theme->construct_footer();



$ger->imprimir('</section>');

$ger->get_js("js/cad_prod.js");

$ger->imprimir('</body>');
