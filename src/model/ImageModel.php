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

        // die(var_dump($valores));

        $sql = new Sql();
        return $sql->store($data['table'], $data['valores'], $data['campos'], $data['indexCampos']);
    }
}