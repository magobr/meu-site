<?php

namespace Controller;

use Service\AccessService;
use Controller\BlogController;
use Controller\UserController;
use Model\PostsModel;

class AdminController extends PostsModel
{

    function getUser()
    {
        $user = UserController::getUserCookie($_COOKIE["USER_TOKEN"]);
        $user = get_object_vars($user);
        return $user[0];
    }

    function renderUserPosts()
    {
        $user = $this->getUser();
        
        $result = BlogController::getPostsUser($user->{"id"});

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $access = AccessService::getAccess();

        $template = $twig->load('pages/adminPosts.twig');
        echo $template->render([
            "data" => $result["data"],
            "user_id" => $user->{"id"},
            "user_nome" => $user->{"nome"},
            "user_email" => $user->{"email"},
            "user_acesso" => $user->{"acesso"},
            "acessos" => $access
        ]);
        return;
    }

    function renderEditPosts($id)
    {
        $user = $this->getUser();
        
        $result = BlogController::getPost($id);

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $access = AccessService::getAccess();

        $template = $twig->load('pages/adminPostsEdit.twig');
        echo $template->render([
            "data" => $result[0],
            "postId" => $id,
            "user_acesso" => $user->{"acesso"},
            "acessos" => $access
        ]);
        return;
    }

    function renderDelPosts($id)
    {
        $user = $this->getUser();

        $result = BlogController::getPost($id);

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $access = AccessService::getAccess();

        $template = $twig->load('pages/adminPostsDel.twig');
        echo $template->render([
            "data" => $result[0],
            "postId" => $id,
            "user_acesso" => $user->{"acesso"},
            "acessos" => $access
        ]);
        return;
    }

    function renderNewPost()
    {
        $user = $this->getUser();

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);

        $access = AccessService::getAccess();

        $template = $twig->load('pages/adminPostsNew.twig');
        echo $template->render([
            "id" => $user->{'id'},
            "user_acesso" => $user->{"acesso"},
            "acessos" => $access
        ]);
        return;
    }
}