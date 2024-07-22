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
                        <h4><i class="fa fa-angle-right"></i> Impressão via arquivo XML NF-E</h4>
                        <form id="arqxml" enctype="multipart/form-data">
                            <div class="form-panel">
                                <div class="form-group has-success">
                                    <label class="col-lg-2 control-label">Arquivo XML</label>
                                    <div class="col-lg-10">
                                        <input type="file" placeholder="" id="f-name" name="arquivo" class="form-control">
                                    </div>
                                </div>
                                <button class="btn btn-success btn-lg" type="submit">Enviar</button>
                            </div>
                        </form>
                        <br>
                        <br>
                        <button onclick="processar()" class="btn btn-success btn-lg" type="submit">Processar</button>
                        <button onclick="limpar()" class="btn btn-danger btn-lg" type="submit">Limpar Fila</button>
                        <br>
                        <br>
                        <table name = "tabelaArquivos" id="tabelaArquivos" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-bullhorn"></i> Arquivo</th>
                                    <th><i class="fa fa-cogs" aria-hidden="true"></i> Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Conteúdo da tabela -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </section>

    
    ');



    $theme->construct_footer(); 

    

    $ger->imprimir('</section>');

    $ger->get_js("js/impxml.js");

    $ger->imprimir('</body>');



?>