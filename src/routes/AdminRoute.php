<?php

namespace Routes;

use Pecee\SimpleRouter\SimpleRouter;

use Controller\AdminController;
use Controller\ViewController;

use Middleware\Auth;
use Middleware\Access;

class AdminRoute
{
    static public function renderPages()
    {
        SimpleRouter::group(["middleware" => Auth::class, "prefix" => "/admin"], function ()
        {
            SimpleRouter::group(["prefix" => "/posts", "middleware" => Access::class], function ()
            {
                SimpleRouter::get('/new', [AdminController::class, "renderNewPost"]);
                SimpleRouter::get('/edit/{id}', [AdminController::class, "renderEditPosts", $params='']);
                SimpleRouter::get('/delete/{id}', [AdminController::class, "renderDelPosts", $params='']);
            });

            SimpleRouter::group(["prefix" => "/image", "middleware" => Access::class], function()
            {
                SimpleRouter::get('/', [AdminController::class, "renderImage"]);
            });

            SimpleRouter::get('/posts', [AdminController::class, "renderUserPosts"]);
            SimpleRouter::get('/', [ViewController::class, "renderLogin"]);
        });
    }
}