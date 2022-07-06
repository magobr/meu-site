<?php

namespace View\Controller;

class ViewController
{
    static function renderPage()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('index.twig');
        echo $template->render();
        return;
    }

    static function renderBlog()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('pages/blogs.twig');
        echo $template->render();
        return;
    }


    static function errorPage()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('error/404.twig');
        echo $template->render();
        return;
    }
    static function forbiddenPage()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('error/403.twig');
        echo $template->render();
        return;
    }

}