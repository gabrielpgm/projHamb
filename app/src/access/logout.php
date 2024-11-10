<?php


include_once(__DIR__ . "/../../public/gerais.php");


use \app\public_\seguranca;

$sec = new seguranca();

$sec->setCustomCookie("user_ck", null);

