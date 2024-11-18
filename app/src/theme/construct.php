<?php

namespace app\src\theme;

include_once(__DIR__ . "/../../public/gerais.php");
include_once(__DIR__ . "/../../database/database.php");
include_once(__DIR__ . "/../config/config_system.php");

use app\public_\gerais;
use app\database\connect;
use app\config\setting;

class construct_theme
{



  public function construct_head($login = false)
  {




    $ger = new gerais();

    $path = "../../assets/";

    $ger->imprimir('<head>');
    $ger->imprimir('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
    $ger->imprimir('<meta name="description" content="">');
    $ger->imprimir('<meta name="author" content="Gabriel Amaro">');
    $ger->imprimir('<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">');
    $ger->imprimir('<title>Hamburguer</title>');

    //Icones

    $ger->imprimir('<link href="' . $path . 'img/favicon.png" rel="icon">');
    $ger->imprimir('<link href="' . $path . 'img/apple-touch-icon.png" rel="apple-touch-icon">');

    //Importação de CSS 
    $ger->imprimir('<link href="' . $path . 'lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">');
    $ger->imprimir('<link href="' . $path . 'lib/font-awesome/css/font-awesome.css" rel="stylesheet">');
    $ger->imprimir('<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">');
    $ger->imprimir('<link rel="stylesheet" type="text/css" href="' . $path . 'css/zabuto_calendar.css">');
    $ger->imprimir('<link rel="stylesheet" type="text/css" href="' . $path . 'lib/gritter/css/jquery.gritter.css" />');
    $ger->imprimir('<link href="' . $path . 'css/style.css" rel="stylesheet">');
    $ger->imprimir('<link href="' . $path . 'css/style-responsive.css" rel="stylesheet">');


    //JAVA SCRIPT
    $ger->imprimir('<script src="' . $path . 'lib/chart-master/Chart.js"></script>');
    $ger->imprimir('<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>');
    $ger->imprimir('<script src="' . $path . 'msg.js"></script>');
    $ger->imprimir('</head>');
  }


  public function construct_menu()
  {

    $ger = new gerais();
    include_once(__DIR__ . "/../access/check_access.php");
    $path = "../../assets/";

    //HEADER DE CIMA
    $ger->imprimir('<header class="header black-bg">');
    $ger->imprimir('    <div class="sidebar-toggle-box">');
    $ger->imprimir('        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>');
    $ger->imprimir('    </div>');
    $ger->imprimir('    <a href="../home/index.php" class="logo"><b>BURGUER<span>MASTER</span></b></a>');
    $ger->imprimir('    <div class="top-menu">');
    $ger->imprimir('        <ul class="nav pull-right top-menu">');
    $ger->imprimir('            <li><button onclick="logout();" class="logout" >Logout</button></li>');
    $ger->imprimir('        </ul>');
    $ger->imprimir('    </div>');
    $ger->imprimir('</header>');

    //CARREGA MENU DINAMICO

    $ger->imprimir('<aside>');
    $ger->imprimir('    <div id="sidebar" class="nav-collapse ">');
    $ger->imprimir('        <p style="margin-top: 70px;" class="centered"><a href="#"><img src="' . $path . 'img/user_profile.png" class="img-circle" width="80"></a></p>');
    $ger->imprimir('        <h5 class="centered">Hamburgueria</h5>');
    $ger->imprimir('        <p class="centered">' . $nome_geral . '</p>');
    $ger->imprimir('        <ul class="sidebar-menu" id="nav-accordion">');

    //CARREGA MENUS

    $this->construct_menu_dinamico();


    $ger->imprimir('        </ul>');
    $ger->imprimir('    </div>');
    $ger->imprimir('</aside>');
  }

  function construct_menu_dinamico()
  {


    $ger = new gerais();

    $ger->imprimir('<li class="sub-menu">');
    $ger->imprimir('    <a href="/../public/cardapio/index.php">');
    $ger->imprimir('        <i class="fa-regular fa-file-lines"></i> Cardápio</i>');
    $ger->imprimir('    </a>');
    $ger->imprimir('</li>');

    $ger->imprimir('<li class="sub-menu">');
    $ger->imprimir('    <a href="javascript:;">');
    $ger->imprimir('        <i class="fa-solid fa-users-gear"></i> Administrativos</i>');
    $ger->imprimir('        <span></span>');
    $ger->imprimir('    </a>');
    $ger->imprimir('        <ul class="sub">');
    $ger->imprimir("            <li><a href='../produtos/list_categoria.php'>Categorias</a></li>");
    $ger->imprimir('        </ul>');
    $ger->imprimir('        <ul class="sub">');
    $ger->imprimir("            <li><a href='../produtos/list_prod.php'>Produtos</a></li>");
    $ger->imprimir('        </ul>');
    $ger->imprimir('</li>');


    $ger->imprimir('<li class="sub-menu">');
    $ger->imprimir('    <a href="javascript:;">');
    $ger->imprimir('        <i class="fa-solid fa-users"></i> Usuários</i>');
    $ger->imprimir('        <span></span>');
    $ger->imprimir('    </a>');
    $ger->imprimir('        <ul class="sub">');
    $ger->imprimir("            <li><a href='../usuarios/list_user.php'>Cadastrar</a></li>");
    $ger->imprimir('        </ul>');
    $ger->imprimir('</li>');
    
    $ger->imprimir('<li class="sub-menu">');
    $ger->imprimir('    <a href="../produtos/list_pedidos.php">');
    $ger->imprimir('        <i class="fa-solid fa-receipt"></i> Pedidos</i>');
    $ger->imprimir('    </a>');
    $ger->imprimir('</li>');
  }


  public function construct_footer()
  {

    $path = "../../assets/";


    $setting = new setting();
    $ger = new gerais();

    $ger->imprimir('<footer class="site-footer">');
    $ger->imprimir('    <div class="text-center">');
    $ger->imprimir('        <p>&copy; Copyrights <strong></strong>. Versão: 1.0 </p>');
    $ger->imprimir('        <p>Contato: <strong></strong>. oliveira.gbr@gmail.com </p>');
    $ger->imprimir('    </div>');
    $ger->imprimir('</footer>');

    //CHAMA JAVASCRIPT
    $ger->imprimir('<script src="' . $path . 'lib/jquery/jquery.min.js"></script>');
    $ger->imprimir('<script src="' . $path . 'lib/bootstrap/js/bootstrap.min.js"></script>');
    $ger->imprimir('<script class="include" type="text/javascript" src="' . $path . 'lib/jquery.dcjqaccordion.2.7.js"></script>');
    $ger->imprimir('<script src="' . $path . 'lib/jquery.scrollTo.min.js"></script>');
    $ger->imprimir('<script src="' . $path . 'lib/jquery.nicescroll.js" type="text/javascript"></script>');
    $ger->imprimir('<script src="' . $path . 'lib/jquery.sparkline.js"></script>');
    $ger->imprimir('<script src="' . $path . 'lib/common-scripts.js"></script>');
    $ger->imprimir('<script type="text/javascript" src="' . $path . 'lib/gritter/js/jquery.gritter.js"></script>');
    $ger->imprimir('<script type="text/javascript" src="' . $path . 'lib/gritter-conf.js"></script>');
    $ger->imprimir('<script src="' . $path . 'lib/sparkline-chart.js"></script>');
    $ger->imprimir('<script src="' . $path . 'lib/zabuto_calendar.js"></script>');



    $ger->imprimir("

            <script type='application/javascript'> 
            
            
            $(document).ready(function() {
                $('#date-popover').popover({
                  html: true,
                  trigger: 'manual'
                });
                $('#date-popover').hide();
                $('#date-popover').click(function(e) {
                  $(this).hide();
                });
              
                $('#my-calendar').zabuto_calendar({
                  action: function() {
                    return myDateFunction(this.id, false);
                  },
                  action_nav: function() {
                    return myNavFunction(this.id);
                  },
                  ajax: {
                    url: 'show_data.php?action=1',
                    modal: true
                  },
                  legend: [{
                      type: 'text',
                      label: 'Special event',
                      badge: '00'
                    },
                    {
                      type: 'block',
                      label: 'Regular event',
                    }
                  ]
                });
              });


            function myNavFunction(id) {
                $('#date-popover').hide();
                var nav = $('#' + id).data('navigation');
                var to = $('#' + id).data('to');
                console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
              }
              </script>
              ");
  }
}
