<!DOCTYPE html>
<?php

include_once(__DIR__ . "/../../app/src/theme/construct.php");
include_once(__DIR__ . "/../../app/public/gerais.php");


use app\src\theme\construct_theme;
use app\public_\gerais;

$ger = new gerais();
$theme = new construct_theme();
$theme->construct_head(true);

?>


<body>

  <div id="login-page">
    <div class="container">
      <form class="form-login" id="formPesquisa" action="javascript:void(0);">
        <h2 class="form-login-heading">Hamburgueria do Gabriel</h2>
        <div class="login-wrap">
          <input type="text" class="form-control" name="usuario" placeholder="Usuário" autofocus>
          <br>
          <input type="password" class="form-control" name="senha" placeholder="Senha">
          <br>
          <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
          <hr>

        </div>

      </form>
    </div>
  </div>

  <script src="../../assets/lib/jquery/jquery.min.js"></script>
  <script src="../../assets/lib/bootstrap/js/bootstrap.min.js"></script>



  <script type="text/javascript" src="../../assets/lib/jquery.backstretch.min.js"></script>
  <script>
    $.backstretch("../../assets/img/tela_login.jpg", {
      speed: 1500
    });
  </script>
  <?php
  $ger->get_js("js/login.js");
  ?>
</body>

</html>