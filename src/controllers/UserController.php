<?php

namespace User\Controller;

require_once __DIR__.'/../model/UserModel.php';

use User\Model\UserModel;
use Ramsey\Uuid\Uuid;
use Pecee\SimpleRouter\SimpleRouter;

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
                "false" => true,
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
            "false" => true,
            "Message" => "Usuário cadastrado com sucesso"
        ]);
    }
}