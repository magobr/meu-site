<?php

namespace Service;

use Model\AccessModel;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AccessService
{

    static function getUserAccess()
    {
        $user = JWT::decode($_COOKIE['USER_TOKEN'], new key($_ENV['KEYJWT'], 'HS256'));
        $user = json_decode(json_encode($user->{"0"}), true);
        return $user["acesso"];
    }

    static function getAccess()
    {
        $getAccess = AccessModel::findAccess();
        $result = [];

        foreach($getAccess as $access){
            $result[strtolower($access["description"])] = $access["id"];
        }
        return $result;
    }

    static function levelAccess($accessLevel)
    {
        $getAccess = AccessModel::levelAccess($accessLevel);
        $result = "";

        if (count($getAccess) != 0) {
            foreach($getAccess as $access){ 
                $result = $access['pagesAccess'];
            }
            $result = explode(",", $result);
        }
        return $result;
    }
}