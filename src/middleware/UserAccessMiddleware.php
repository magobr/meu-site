<?php

namespace UserAccess\Middleware;

require_once __DIR__.'/../services/MainService.php';

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use MainService\Service\MainService;

class UserAccess implements IMiddleware
{   
    public function handle(Request $request): void 
    {
        die(var_dump($this->getUserAccess()));
    }

    public function getUserAccess()
    {
        $user = JWT::decode($_COOKIE['USER_TOKEN'], new key($_ENV['KEYJWT'], 'HS256'));
        $user = json_decode(json_encode($user->{"0"}), true);
        return $user["acesso"];
    }
   
}