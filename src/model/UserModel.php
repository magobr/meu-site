<?php

namespace User\Model;

require_once __DIR__.'/../config/Conn.php';

use Config\Conn\Sql;

class UserModel extends Sql
{

    protected const TABLE = "USER_POSTER";

    static public function getUser($value, $field)
    {

        $data = [
            "table" => self::TABLE,
            "params"=>"WHERE USER_POSTER.$field = :$field",
            "values" => [
                "$field" => $value
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params']);
    }

    static public function getForLoginUser($email, $password)
    {
        $data =[
            "campos" => "id, nome, email, created_at, acesso",
            "table" => self::TABLE,
            "params"=>"WHERE USER_POSTER.email = :email AND USER_POSTER.senha = :senha",
            "values" => [
                "email" => $email,
                "senha" => $password
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params'], $data['campos']);
    }

    static public function storeUser($valores)
    {

        $data = [
            "table" => self::TABLE,
            "campos" => "id, nome, email, senha, acesso",
            "indexCampos" => ":id, :nome, :email, :senha, :acesso",
            "valores" => $valores
        ];

        $sql = new Sql();
        return $sql->store($data['table'], $data['valores'], $data['campos'], $data['indexCampos']);
    }

    static public function updateUser($dados, $user_id)
    {
        $data = [
            "table" => self::TABLE,
            "campos" => ["nome", "email", "acesso"],
            "valores" => $dados,
            "indexCampos" => [":nome", ":email", ":acesso"],
            "params"=>"WHERE id = '$user_id';"
        ];

        $sql = new Sql();
        return $sql->updateItem($data["table"], $data["valores"], $data["campos"], $data["params"], $data["indexCampos"]);
    }

    static public function updateUserPassword($newPass, $user_id)
    {
        $data = [
            "table" => self::TABLE,
            "campos" => ["senha"],
            "valores" => $newPass,
            "indexCampos" => [":senha"],
            "params"=>"WHERE id = '$user_id';"
        ];

        $sql = new Sql();
        return $sql->updateItem($data["table"], $data["valores"], $data["campos"], $data["params"], $data["indexCampos"]);
    }

    static public function deleteUser($id)
    {
        $data = [
            "table" => self::TABLE,
            "params" => "id = :id",
        ];

        $sql = new Sql();
        return $sql->delItem($data["table"], ["id" => $id], $data["params"]);
    }
}
