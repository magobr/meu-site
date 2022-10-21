<?php

namespace MainService\Service;

class MainService
{

    static function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }

}