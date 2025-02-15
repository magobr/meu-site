<?php

namespace Model;

use Config\Sql;

class ImageModel extends Sql
{
    static public function storeImage($valores)
    {
        $data = [
            "table" => "POSTS_COVER",
            "campos" => "id, image",
            "indexCampos" => ":id, :image",
            "valores" => $valores
        ];

        $sql = new Sql();
        return $sql->store($data['table'], $data['valores'], $data['campos'], $data['indexCampos']);
    }

    static public function getImages()
    {
        $data = [
            "table" => "POSTS_COVER",
            "params" => "",
            "values" => []
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data['values'], $data['params']);
    }

    static public function getImage($id)
    {
        $data = [
            "table" => "POSTS_COVER",
            "condicao" => "WHERE id = :id",
            "values" => [
                "id" => $id
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data['values'], $data['condicao']);
    }

    static public function deleteImage($id)
    {
        $data = [
            "table" => "POSTS_COVER",
            "condicao" => "id = :id",
            "values" => [
                "id" => $id
            ]
        ];

        $sql = new Sql();
        return $sql->delItem($data['table'], $data['values'], $data['condicao']);
    }
}