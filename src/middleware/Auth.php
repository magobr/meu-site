<?php

namespace Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

use Service\MainService;

class Auth implements IMiddleware
{   
    public function handle(Request $request): void 
    {
        // Logado
        if($this->isAuthenticated()){
            if($request->getUrl() == "/admin/"){
                MainService::Redirect("/admin/posts");
                return;
            }
            return;
        }

      // Não Logado
        if(!$this->isAuthenticated()){
            if($request->getUrl() != "/admin/"){
                MainService::Redirect("/admin");
                return;
            }
            return;
        }
    }

    public function isAuthenticated()
    {
        if (!$this->isSetCookie()) {
            return false;
        }

        if($_COOKIE['USER_LOGIN'] !== "1"){
            return false;
        }
        
        return true;
    }

    public function isSetCookie()
    {
        if (!isset($_COOKIE['USER_LOGIN'])) {
            return false;
        }
        return true;
    }
   
}