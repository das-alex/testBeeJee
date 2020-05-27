<?php

define('ROOT', dirname(__FILE__));
require_once("router.class.php");

$router = new Router();
$router->start();