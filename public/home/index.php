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





    $theme->construct_footer(); 

    $ger->imprimir('</section>');
    $ger->imprimir('</body>');


?>