<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Myproject\App(__DIR__ . '/../', 'dev');
$app->run();
