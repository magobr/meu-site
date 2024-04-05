<?php

namespace Model;

use Config\Sql;

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

    static public function levelAccess($data)
    {
        $data = [
            "table" => "USER_PERMISSION",
            "params"=> "WHERE USER_PERMISSION.id = :id",
            "values" => [
                "id" => $data
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params']);
    }
}