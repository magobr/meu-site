<?php

namespace User\Model;

require_once __DIR__.'/../config/Conn.php';

use Config\Conn\Sql;

class UserModel extends Sql
{

    static public function getUser($email)
    {
        $data =[
            "table" => "USER_POSTER",
            "params"=>"WHERE USER_POSTER.email = '$email'"
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data['params']);
    }

    static public function storeUser($valores)
    {

        $data = [
            "table" => "USER_POSTER",
            "campos" => "id, nome, email, senha",
            "indexCampos" => ":id, :nome, :email, :senha",
            "valores" => $valores
        ];


        $sql = new Sql();
        return $sql->store($data['table'], $data['valores'], $data['campos'], $data['indexCampos']);
    }
}
