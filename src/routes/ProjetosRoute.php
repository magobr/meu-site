<?php

namespace Routes;

use Pecee\SimpleRouter\SimpleRouter;

use Controller\ProjetosController;

class ProjetosRoute
{
    static public function renderPages()
    {
        SimpleRouter::group(["prefix" => "/projetos"], function()
        {
            SimpleRouter::group(["prefix" => "/api"], function ()
            {
                SimpleRouter::get('/', [ProjetosController::class, "getProjetos"]);    
            });
            SimpleRouter::get('/', [ProjetosController::class, "renderUserProjetos"]);    
        });
    }
}   