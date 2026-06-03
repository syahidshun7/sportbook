<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/core/App.php';

$app = new App();
$app->run();
