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
            SimpleRouter::group(["prefix" => "/posts"], function ()
            {
                SimpleRouter::get('/{id}', [BlogController::class, "getPost", $params='']);
                SimpleRouter::get('/user/{id}', [BlogController::class, "getPostByUser", $params='']);       
                
                SimpleRouter::group(["middleware" => Access::class], function ()
                {
                    SimpleRouter::post('/new', [BlogController::class, "insertPost"]);
                    SimpleRouter::put('/edit/{id}', [BlogController::class, "updatePosts", $params='']);
                    SimpleRouter::delete('/delete/{id}', [BlogController::class, "purgePost", $params='']);
                });
            });
            
            SimpleRouter::group(["middleware" => Auth::class, "prefix" => "/user"], function()
            {
                SimpleRouter::post('/new', [UserController::class, "insertUser"]);
                SimpleRouter::put('/update/{id}', [UserController::class, "update", $params='']);
                SimpleRouter::put('/update/pass/{id}', [UserController::class, "updatePassword", $params='']);
                SimpleRouter::delete('/delete/{id}', [UserController::class, "delete", $params='']);
            });

            SimpleRouter::group(["middleware" => Auth::class, "middleware" => Access::class, "prefix" => "/image"], function()
            {
                SimpleRouter::get('/', [ImageController::class, "getImage"]);
                SimpleRouter::post('/new', [ImageController::class, "insertImage"]);
                SimpleRouter::get('/{id}', [ImageController::class, "getImageId", $params='']);
                SimpleRouter::delete('/{id}', [ImageController::class, "deleteImage", $params='']);
            });

        });
    }
}