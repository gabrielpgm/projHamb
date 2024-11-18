<?php
// Incluindo arquivos necessários
include_once(__DIR__ . "/../../app/src/theme/construct.php");
include_once(__DIR__ . "/../../app/public/gerais.php");

use app\src\theme\construct_theme;
use app\public_\gerais;

// Inicializando o tema e outros objetos
$theme = new construct_theme();
$ger = new gerais();

// Cabeçalho e estrutura inicial da página
$theme->construct_head();
$ger->imprimir('<body>');
$ger->imprimir('<section id="container">');
$theme->construct_menu();

$ger->imprimir('
    <section id="main-content">
        <section class="wrapper">
            <div class="row mt">
                <div class="col-lg-12">
                    <h4><i class="fa fa-angle-right"></i> Gestão de Pedidos</h4>
                    <div class="form-panel">
                        <form action="javascript:void(0);" id="formPesquisa" class="form-inline">
                            <div class="form-group mr-2">
                                <label for="data_inicio" class="mr-2">Data Início:</label>
                                <input type="date" id="data_inicio" name="data_inicio" class="form-control" required />
                            </div>
                            <div class="form-group mr-2">
                                <label for="data_fim" class="mr-2">Data Fim:</label>
                                <input type="date" id="data_fim" name="data_fim" class="form-control" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </form>

                    </div>
                    
                    <div id="pedidosContainer" class="row">
                    </div>
                </div>
            </div>
        </section>
    </section>
');

// Rodapé da página
$theme->construct_footer();
$ger->imprimir('</section>');
$ger->get_js("js/list_pedidos.js");
$ger->imprimir('</body>');
?>
