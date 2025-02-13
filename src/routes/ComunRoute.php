<?php

namespace Routes;

use Pecee\SimpleRouter\SimpleRouter;

use Controller\ViewController;
use Controller\BlogController;


class ComunRoute {
    static public function renderPages() {
        SimpleRouter::get('/', [ViewController::class, "renderPage"]);

        SimpleRouter::group(["prefix" => "/blog"], function ()
        {
            SimpleRouter::get('/', [BlogController::class, "renderPosts"]);
            SimpleRouter::get('/{id}', [BlogController::class, "renderPost", $params='']);
        });
    }
}