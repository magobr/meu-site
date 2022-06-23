<?php
require_once __DIR__ . '/vendor/autoload.php';
use Pecee\SimpleRouter\SimpleRouter;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once './src/routes.php';

SimpleRouter::start();