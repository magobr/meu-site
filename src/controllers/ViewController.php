<?php

namespace View\Controller;

class ViewController
{
    static function renderPage()
    {
        $htmlPage =  __DIR__."/../view/index.html";
        readfile($htmlPage);
        return;
    }

    static function errorPage()
    {
        $htmlPage =  __DIR__."/../view/error/404.html";
        readfile($htmlPage);
        return;
    }

    static function forbiddenPage()
    {
        $htmlPage =  __DIR__."/../view/error/403.html";
        readfile($htmlPage);
        return;
    }

}