<?php

namespace Image\Model;

require_once __DIR__.'/../config/Conn.php';

use Config\Conn\Sql;

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
}