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
            <h4><i class="fa fa-angle-right"></i> Configurações do Sistema</h4>
            <div class="form-panel">
                <form id="formPesquisa" role="form" class="form-horizontal style-form" action="javascript:void(0);">
                <div class="form-group has-success">
                    <label class="col-lg-2 control-label">Inventário</label>
                    <div class="col-lg-10">
                    <input type="number" placeholder="" id="f-name" name = "inventario" class="form-control">
                    <p class="help-block">Número Atual do Inventário</p>
                    </div>
                </div>
                <div class="form-group has-success">
                    <label class="col-lg-2 control-label">Time out Sincronização</label>
                    <div class="col-lg-10">
                    <input type="time" placeholder="" id="f-name" name = "timeout" class="form-control">
                    <p class="help-block">Time Out de Sincronização de Produtos</p>
                    </div>
                </div>
                <div class="form-group has-success">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-10">
                        <div class="showback">
                        <h4   id="produto_atual"><i class="fa fa-angle-right">Progresso de Sincronização:
                        </i></h4>
                            <div class="progress progress-striped active">
                                <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <span class="sr-only">45% Complete</span>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-theme" type="submit">Gravar Configurações</button>
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

    $ger->get_js("js/configuracoes.js");

    $ger->imprimir('</body>');



?>