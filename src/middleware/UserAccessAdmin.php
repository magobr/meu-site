<?php

namespace Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

use Service\AccessService;
use Service\MainService;

class UserAccessAdmin implements IMiddleware
{   
    public function handle(Request $request): void 
    {

        if (AccessService::levelAdmin() === AccessService::getUserAccess()){
            return;
        }

        MainService::Redirect("/not-found");
    }
}