<?php

require_once __DIR__.'/controllers/ViewController.php';

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use Pecee\Http\Response;
use View\Controller\ViewController;

SimpleRouter::get('/', [ViewController::class, "renderPage"]);

SimpleRouter::get('/not-found', [ViewController::class, "errorPage"]);

SimpleRouter::get('/forbidden', [ViewController::class, "forbiddenPage"]);


SimpleRouter::error(function(Request $request, \Exception $exception) {

    switch($exception->getCode()) {
        // Page not found
        case 404:
            SimpleRouter::response()->redirect('/not-found');
        // Forbidden
        case 403:
            SimpleRouter::response()->redirect('/forbidden');
    }
    
});