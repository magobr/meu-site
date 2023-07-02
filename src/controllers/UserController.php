<?php

namespace User\Controller;

require_once __DIR__.'/../model/UserModel.php';
require_once __DIR__.'/../services/MainService.php';

use User\Model\UserModel;
use MainService\Service\MainService;

use Ramsey\Uuid\Uuid;
use Pecee\SimpleRouter\SimpleRouter;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends UserModel
{

    static public function insertUser()
    {
        $str_json = json_decode(file_get_contents('php://input'));
        $valores = get_object_vars($str_json);
        $userUuid = Uuid::uuid4();

        $userExists = UserModel::getUser($str_json->{'email'}, "email");
        if (isset($userExists['error'])) {
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

        $valores["id"] = $userUuid->toString();
        $valores["senha"] = md5($valores["senha"]);

        
        $resp = UserModel::storeUser($valores);

        die(var_dump($resp));

        SimpleRouter::response()->httpCode(201)->json([
            "error" => false,
            "Message" => "Usuário cadastrado com sucesso"
        ]);
    }

    static public function update($id)
    {
        $str_json = json_decode(file_get_contents('php://input'));
        $valores = get_object_vars($str_json);

        if ($valores["nome"] == "" OR !$valores["nome"]) {
            SimpleRouter::response()->json([
                "error" => true,
                "message" => "Preencha o campo Nome"
            ]);
        }

        if ($valores["email"] == "" OR !$valores["email"]) {
            SimpleRouter::response()->json([
                "error" => true,
                "message" => "Preencha o campo Email"
            ]);
        }

        $resp = UserModel::updateUser($valores, $id);

        if ($resp["error"]) {
            SimpleRouter::response()->httpCode(200)->json([$resp]);
        }

        SimpleRouter::response()->httpCode(201)->json([
            "error" => false,
            "Message" => "Usuário Atualizado com sucesso"
        ]);
    }

    static public function updatePassword($id)
    {
        $str_json = json_decode(file_get_contents('php://input'));
        $valores = get_object_vars($str_json);

        $valores["senha"] = md5($valores["senha"]);

        if ($valores["senha"] == "" OR !$valores["senha"]) {
            SimpleRouter::response()->json([
                "error" => true,
                "message" => "Preencha o campo Senha"
            ]);
        }

        $resp = UserModel::updateUserPassword($valores, $id);

        if ($resp["error"]) {
            SimpleRouter::response()->httpCode(200)->json([$resp]);
        }

        SimpleRouter::response()->httpCode(201)->json([
            "error" => false,
            "Message" => "Senha Atualizado com sucesso"
        ]);
    }
    
    static public function delete($id)
    {
        $user = UserModel::getUser($id, "id");

        if ($user['error']) {
            SimpleRouter::response()->json([
                $user
            ]);
        }
        
        if (sizeof($user) === 0) {
            SimpleRouter::response()->json([
                "error" => false,
                "data" => $user,
                "message" => "Não foi encontrado dados"
            ]);
        }
        
        $result = UserModel::deleteUser($id);

        if ($result > 0) {
            SimpleRouter::response()->httpCode(202)->json([
                "error" => false,
                "Message" => "Usuario deletado com sucesso"
            ]);
        }

        SimpleRouter::response()->httpCode(202)->json([
            "error" => true,
            "Message" => "Erro ao executar essa ação"
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
                "message" => $dataError
            ]);
        }

        $userExists = UserModel::getUser($userData["email"], "email");
        
        if (count($userExists) === 0) {
            SimpleRouter::response()->httpCode(409)->json([
                "error" => true,
                "message" => "Usuário não cadastrado"
            ]);
        }

        $userLogin = UserModel::getForLoginUser($userData["email"], md5($userData["senha"]));

        if (isset($userLogin['error'])) {
            SimpleRouter::response()->json([
                $userLogin
            ]);
        }

        if (count($userLogin) === 0) {
            SimpleRouter::response()->httpCode(409)->json([
                "error" => true,
                "message" => "E-mail ou Senha inválidos"
            ]);
        }

        $requestJwt = $this->requestJwt($userLogin);
        list($realHost,)=explode(':',$_SERVER['HTTP_HOST']);

        setcookie("USER_TOKEN", $requestJwt, time()+60*60*24*30, "/", $realHost);
        setcookie("USER_LOGIN", true, time()+60*60*24*30, "/", $realHost);

        SimpleRouter::response()->httpCode(200)->json([
            "error" => false,
            "message" => "Logado com Sucesso",
            "data" => $userLogin
        ]);
    }

    public function logout()
    {
        list($realHost,)=explode(':',$_SERVER['HTTP_HOST']);
        unset($_COOKIE["USER_TOKEN"]);
        unset($_COOKIE["USER_LOGIN"]);
        setcookie("USER_TOKEN", null, time() - 3600, '/', $realHost);
        setcookie("USER_LOGIN", null, time() - 3600, '/', $realHost);
        MainService::Redirect('/admin');
    }

    public static function getUserCookie($cookie){
        $user = JWT::decode($cookie, new key($_ENV['KEYJWT'], 'HS256') );
        return $user;
    }
}