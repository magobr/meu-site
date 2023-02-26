<?php

namespace Access\Model;

require_once __DIR__.'/../config/Conn.php';

use Config\Conn\Sql;

class AccessModel extends Sql
{
    static public function findAccess()
    {
        $data = [
            "table" => "USER_PERMISSION",
        ];

        $sql = new Sql();
        return $sql->find($data['table']);
    }

    static public function levelAdmin()
    {
        $data = [
            "table" => "USER_PERMISSION",
            "params"=> "WHERE USER_PERMISSION.id = :id",
            "values" => [
                "id" => "33f815d4-1673-4c91-93fa-104f1c344a29"
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params']);
    }

    static public function levelWriter()
    {
        $data = [
            "table" => "USER_PERMISSION",
            "params"=> "WHERE USER_PERMISSION.id = :id",
            "values" => [
                "id" => "b49bad49-3d16-4cc7-8334-070940fb7697"
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params']);
    }
}