<?php

namespace Blog\Controller;

require_once __DIR__.'/../model/ImageModel.php';

use Image\Model\ImageModel;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use Posts\Model\PostsModel;
use Ramsey\Uuid\Uuid;

class ImageController
{

    private function validateImage($arrImage)
    {
        $d = dir(getcwd());

        $name = $arrImage['image']['name'];
        $fileSize = $arrImage['image']['size'];
        $target_dir = $d->path . "/upload/";
        $target_file = $target_dir . basename($arrImage["image"]["name"]);

        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $extensions_arr = array("jpg","jpeg","png","gif");
    
        if(!in_array($imageFileType,$extensions_arr) ){
            return [
                "error" => true,
                "message" => "Erro ao inserir imagem no banco de dados"
            ];
        }

        if ($fileSize > 300000) {
            return [
                "error" => true,
                "message" => "Imagem maior que 300MB"
            ];
        }

        $moveImage = move_uploaded_file($arrImage['image']['tmp_name'],$target_dir.$name);
        if(!$moveImage){
            return [
                "error" => true,
                "message" => "Erro ao inserir imagem no diretório temporário"
            ];
        }

        $image_base64 = base64_encode(file_get_contents($target_dir.$name));
        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
        // die(var_dump($image));

        return $image;

    }

    public function insertImage()
    {
        $arrInput = json_decode(file_get_contents('php://input'));
        $imageUuid = Uuid::uuid4();

        $validImage = $this->validateImage($_FILES);

        if (!$validImage) {
            SimpleRouter::response()->httpCode(200)->json([
                "error" => true,
                "Message" => $validImage['message']
            ]);
        }

        $resp = ImageModel::storeImage([
            "id" => $imageUuid,
            "image" => $validImage
        ]);

        if ($resp['error']) {
            SimpleRouter::response()->httpCode(200)->json([
                $resp
            ]);
        }

        SimpleRouter::response()->httpCode(200)->json([
            "error" => false,
            "Message" => "Post publicado com sucesso",
            "id" => $imageUuid
        ]);
    }
}