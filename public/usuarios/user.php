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
            <h4><i class="fa fa-angle-right"></i> Paínel do Usuário</h4>
            
            <div class="form-panel">
                <form id="formPesquisa" role="form" class="form-horizontal style-form" action="javascript:void(0);">

                <div class="container">
                    <div class="form-group has-success">
                        <label class="col-lg-2 control-label">Nome do Usuário</label>
                        <div class="col-lg-10">
                        <input type="text" placeholder="" id="f-name" name = "usuario" class="form-control" required autofocus>
                        <p class="help-block">Este é o nome de usuário necessário para Login</p>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="form-group has-success">
                        <label class="col-lg-2 control-label">Nome completo</label>
                        <div class="col-lg-10">
                        <input type="text" placeholder="" id="f-name" name = "nome" class="form-control" required autofocus>
                        <p class="help-block">Este é o nome de Exibição para o usuário</p>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="form-group has-success">
                        <label class="col-lg-2 control-label">Senha</label>
                        <div class="col-lg-10">
                        <input type="password" placeholder="" id="f-name" name = "senha" class="form-control" required>
                        <p class="help-block">Esta é a Senha do usuário</p>
                        </div>
                    </div>
                </div>


                   

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-theme" type="submit">Gravar</button>
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

$ger->get_js("js/user.js");

$ger->imprimir('</body>');
