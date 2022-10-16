<?php

namespace Admin\Controller;

require_once __DIR__.'/../model/PostsModel.php';

use Posts\Model\PostsModel;
use Pecee\SimpleRouter\SimpleRouter;

class AdminController extends PostsModel
{
    static function renderUserPosts()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('pages/adminPosts.twig');
        echo $template->render();
        return;
    }
}