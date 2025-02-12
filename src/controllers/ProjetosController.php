<?php

namespace Controller;

use Utils\ApiUtils;

Class ProjetosController
{
    function getProjetos()
    {
        $repos = ApiUtils::consumeAPI([
            'URL' => "https://api.github.com/users/{$_ENV['GITHUB']}/repos"
        ]);
        return json_encode($repos, JSON_UNESCAPED_SLASHES);
    }

    function renderUserProjetos()
    {
        $repos = $this->getProjetos();
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/projetos.twig');
        $repos = json_decode($repos, true);
        echo $template->render([
            "data" => $repos
        ]);
        return;
    }
}