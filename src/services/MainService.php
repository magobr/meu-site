<?php

namespace Service;

use Controller\UserController;

class MainService
{

    static function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }

    static function getUser()
    {
        $user = UserController::getUserCookie($_COOKIE["USER_TOKEN"]);
        $user = get_object_vars($user);
        return $user[0];
    }

    static function getPagesAccess(){
        return [
            "novo_post" => "posts/new",
            "editar_post" => "posts/edit",
            "apagar_post" => "posts/delete",
            "image" => "image",
        ];
    }

}