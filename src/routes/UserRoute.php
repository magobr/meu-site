<?php

namespace Routes;

use Pecee\SimpleRouter\SimpleRouter;

use Controller\UserController;


class UserRoute
{
    static public function endpoints()
    {
        SimpleRouter::group(["prefix" => "/user"], function ()
        {
            SimpleRouter::post('/login', [UserController::class, "login"]);
            SimpleRouter::get('/logout', [UserController::class, "logout"]);
        });
    }
}