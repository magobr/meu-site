<?php

namespace Routes;

use Pecee\SimpleRouter\SimpleRouter;
use Controller\BlogController;
use Controller\UserController;
use Controller\ImageController;

use Middleware\Access;
use Middleware\Auth;

class ApiRoute
{
    static public function endpoints()
    {
        SimpleRouter::group(["prefix" => "/api"], function ()
        {
            SimpleRouter::get('/posts/{id}', [BlogController::class, "getPost", $params='']);
            SimpleRouter::get('/posts/user/{id}', [BlogController::class, "getPostByUser", $params='']);   
        });

        SimpleRouter::group(["prefix" => "/posts", "middleware" => Access::class], function ()
        {
            SimpleRouter::post('/new', [BlogController::class, "insertPost"]);
            SimpleRouter::put('/edit/{id}', [BlogController::class, "updatePosts", $params='']);
            SimpleRouter::delete('/delete/{id}', [BlogController::class, "purgePost", $params='']);
        });

        SimpleRouter::group(["middleware" => Auth::class, "prefix" => "/user"], function()
        {
            SimpleRouter::post('/new', [UserController::class, "insertUser"]);
            SimpleRouter::put('/update/{id}', [UserController::class, "update", $params='']);
            SimpleRouter::put('/update/pass/{id}', [UserController::class, "updatePassword", $params='']);
            SimpleRouter::delete('/delete/{id}', [UserController::class, "delete", $params='']);

            SimpleRouter::post('/image/new', [ImageController::class, "insertImage"]);
        });
    }
}