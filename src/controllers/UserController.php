<?php

namespace User\Controller;

require_once __DIR__.'/../model/UserModel.php';

use User\Model\UserModel;
use Ramsey\Uuid\Uuid;
use Pecee\SimpleRouter\SimpleRouter;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends UserModel
{

    static public function insertUser()
    {
        $str_json = json_decode(file_get_contents('php://input'));
        $userUuid = Uuid::uuid4();

        $userExists = UserModel::getUser($str_json->{'email'});

        if ($userExists['error']) {
            SimpleRouter::response()->json([
                $userExists
            ]);
        }

        if (count($userExists) !== 0) {
            SimpleRouter::response()->httpCode(409)->json([
                "error" => true,
                "Message" => "Usuário já cadastrado"
            ]);
        }

        $data = [
            "id"=> $userUuid->toString(),
            "nome" => $str_json->{'nome'},
            "email" => $str_json->{'email'},
            "senha" => md5($str_json->{'senha'})
        ];

        UserModel::storeUser($data);

        SimpleRouter::response()->httpCode(201)->json([
            "error" => false,
            "Message" => "Usuário cadastrado com sucesso"
        ]);
    }

    protected function requestJwt($userData)
    {
        $key = $_ENV['KEYJWT'];
        $payload = $userData;
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }

    public function login()
    {
        $str_json = json_decode(file_get_contents('php://input'), true);
        
        $userData = $str_json["user"];

        $dataTrue = true;
        $dataError = [];

        if (!$userData["email"]) {
            $dataTrue = false;
            array_push($dataError, "Preencha o campo Email");
        }

        if (!$userData["senha"]) {
            $dataTrue = false;
            array_push($dataError, "Preencha o campo senha");
        }

        if (!$dataTrue) {
            SimpleRouter::response()->httpCode(409)->json([
                "error" => true,
                "Message" => $dataError
            ]);
        }

        $userExists = UserModel::getUser($userData["email"]);
        
        if (count($userExists) === 0) {
            SimpleRouter::response()->httpCode(409)->json([
                "error" => true,
                "Message" => "Usuário não cadastrado"
            ]);
        }

        $userLogin = UserModel::getForLoginUser($userData["email"], md5($userData["senha"]));

        if ($userLogin['error']) {
            SimpleRouter::response()->json([
                $userLogin
            ]);
        }

        if (count($userLogin) === 0) {
            SimpleRouter::response()->httpCode(409)->json([
                "error" => true,
                "Message" => "E-mail ou Senha inválidos"
            ]);
        }

        $requestJwt = $this->requestJwt($userData);
        list($realHost,)=explode(':',$_SERVER['HTTP_HOST']);

        setcookie("USER_TOKEN", $requestJwt, time()+60*60*24*30, "/", $realHost);
        setcookie("USER_LOGIN", true, time()+60*60*24*30, "/", $realHost);

        SimpleRouter::response()->httpCode(200)->json([
            "error" => false,
            "Message" => "Logado com Sucesso"
        ]);
    }

    public function logout()
    {
        unset($_COOKIE["USER_TOKEN"]);
        unset($_COOKIE["USER_LOGIN"]);

        setcookie("USER_TOKEN", null, time() - 3600, '/');
        setcookie("USER_LOGIN", null, time() - 3600, '/');

        SimpleRouter::response()->httpCode(200)->json([
            "error" => false,
            "Message" => "Deslogado com Sucesso"
        ]);
    }
}