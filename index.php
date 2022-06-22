<?php
require_once __DIR__ . '/vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;

SimpleRouter::error(function (Request $request, \Exception $error){
  http_response_code($error->getCode());
  if ($error) {
    echo $error->getCode();
  }
});

require_once './src/routes.php';

SimpleRouter::start();