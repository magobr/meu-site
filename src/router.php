<?php

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;

use Controller\ViewController;

use Routes\AdminRoute;
use Routes\ApiRoute;
use Routes\ComunRoute;
use Routes\ProjetosRoute;
use Routes\UserRoute;

ComunRoute::renderPages();
AdminRoute::renderPages();
ProjetosRoute::renderPages();

UserRoute::endpoints();
ApiRoute::endpoints();

// error pages
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