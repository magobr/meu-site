<?php

namespace UserAccessAdmin\Middleware;

require_once __DIR__.'/../services/AccessService.php';
require_once __DIR__.'/../services/MainService.php';

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Access\Service\AccessService;
use MainService\Service\MainService;

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