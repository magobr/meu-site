<?php

namespace View\Controller;

class ViewController
{
    static function renderPage()
    {
        $htmlPage =  __DIR__."/../../public/index.html";
        readfile($htmlPage);
    }
}