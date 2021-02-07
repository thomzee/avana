<?php

require_once realpath("vendor/autoload.php");

$main = new \Thomzee\Avana\Controllers\MainController();
$main->index();