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
            SimpleRouter::group(["middleware" => Access::class], function ()
            {
                SimpleRouter::get('/posts/new', [AdminController::class, "renderNewPost"]);
                SimpleRouter::get('/posts/edit/{id}', [AdminController::class, "renderEditPosts", $params='']);
                SimpleRouter::get('/posts/delete/{id}', [AdminController::class, "renderDelPosts", $params='']);
            });

            SimpleRouter::get('/posts', [AdminController::class, "renderUserPosts"]);
            SimpleRouter::get('/', [ViewController::class, "renderLogin"]);
        });
    }
}