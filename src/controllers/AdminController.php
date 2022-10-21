<?php

namespace Admin\Controller;

require_once __DIR__.'/../model/PostsModel.php';

use Blog\Controller\BlogController;
use User\Controller\UserController;
use Posts\Model\PostsModel;
use Pecee\SimpleRouter\SimpleRouter;

class AdminController extends PostsModel
{
    function renderUserPosts()
    {

        $user = UserController::getUserCookie($_COOKIE["USER_TOKEN"]);
        $user = get_object_vars($user);
        $user = $user[0];

        $result = BlogController::getPostByUser($user->{"id"});

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('pages/adminPosts.twig');
        echo $template->render([
            "data" => $result["data"],
            "user_id" => $user->{"id"},
            "user_nome" => $user->{"nome"},
            "user_email" => $user->{"email"}
        ]);
        return;
    }
}