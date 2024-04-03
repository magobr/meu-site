<?php

namespace Controller;

Class ProjetosController
{
    function getProjetos()
    {
        $repos = $this->consumeAPI([
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

    function consumeAPI($data)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $data['URL'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'User-Agent: thiagonovaes'
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}