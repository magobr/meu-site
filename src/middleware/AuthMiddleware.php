<?php

namespace Auth\Middleware;

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class Auth implements IMiddleware
{

    
    public function handle(Request $request): void 
    {
    
        if($_COOKIE['USER_LOGIN'] !== 1 && $request->getUrl() != "/admin/"){
            $this->Redirect("/blog");
            return;
        }

        return;
    }

    function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }

   
}