<?php

namespace Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Service\MainService;
use Service\AccessService;

class Access implements IMiddleware
{   
    public function handle(Request $request): void 
    {
        $path = $_SERVER['REQUEST_URI'];
        $user = MainService::getUser();
        $access = AccessService::levelAccess($user->{"acesso"});
        $accessPages = MainService::getPagesAccess();
        $resp = false;

        foreach ($accessPages as $key => $value) {
            if(str_contains($path, $value) != 0 && in_array($key, $access)){
                $resp = true;
            } 
        }

        if (!$resp) {
            MainService::Redirect("/admin/posts");
        } else {
            return;
        }
    }
}