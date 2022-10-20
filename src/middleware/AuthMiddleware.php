<?php

namespace Auth\Middleware;

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class Auth implements IMiddleware
{   
    public function handle(Request $request): void 
    {
        // Não Logado
        if(!$this->isAuthenticated($request)){

            if($_COOKIE['USER_LOGIN'] !== 1 && $request->getUrl() != "/admin/"){
                die("não logado");
                $this->Redirect("/admin");
                return;
            }
            return;
        }
        // Logado
        $this->Redirect("/user/posts");
    }

    function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }

    public function isAuthenticated()
    {
        if($_COOKIE['USER_LOGIN'] !== "1"){
            return false;
        }
        
        return true;
    }
   
}