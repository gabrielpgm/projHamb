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
                        <h4><i class="fa fa-angle-right"></i> Impressão de Pedidos de Licenciados</h4>
                        <div class="form-panel">
                        <table id = "tabelarfid" class="table table-striped table-advance table-hover">
                        <thead>
                          <tr>
                            <th><i class="fa fa-ticket"></i> Número</th>
                            <th><i class="fa fa-clock-o"></i> Cliente</th>
                            <th><i class="fa fa-key"></i> Representante</th>
                            <th><i class=" fa fa-edit"></i> Emissão</th>
                            <th><i class=" fa fa-signal"></i> Fatura</th>
                            <th><i class=" fa fa-user"></i> Cidade</th>
                            <th><i class=" fa fa-edit"></i></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          
                        </tbody>
                      </table>
                        </div>
                    </div>
                </div>
            </section>
        </section>

    
    ');



    $theme->construct_footer(); 

    

    $ger->imprimir('</section>');

    $ger->get_js("js/implicen.js");

    $ger->imprimir('</body>');



?>