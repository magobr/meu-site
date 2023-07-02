<?php

namespace Auth\Middleware;

require_once __DIR__.'/../services/MainService.php';

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use MainService\Service\MainService;

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