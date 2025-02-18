<?php

namespace Service;

use Model\PostsModel;
use Model\ImageModel;

class AdminService
{
    static public function viewPostByUser($id)
    {
       $result = PostsModel::findPostsByUser($id);
 
       if (isset($result['error']) && $result['error']) {
          return [
             "error" => true,
             "data" => $result,
             "message" => "Erro ao buscar dados"
         ];
       }
 
       if (sizeof($result) === 0) {
          return [
             "error" => true,
             "data" => $result,
             "message" => "Não foi encontrado dados"
         ];
       }
       
       return [
          "error" => false,
          "data" => $result
       ];
    }

    static public function viewPost($id)
   {
      $result = PostsModel::findPostsById($id);

      if (isset($result['error']) && $result['error']) {
         return [
            "error" => true,
            "data" => $result,
            "message" => "Erro ao buscar dados"
      ];
      }

      if (isset($result) && sizeof($result) === 0) {
         return [
            "error" => false,
            "data" => $result,
            "message" => "Não foi encontrado dados"
      ];
      }
      return [
         "error" => false,
         "data" => $result[0]
      ];
   }

   static public function getImage()
   {
      $images = ImageModel::getImages();

      if (isset($images['error']) && $images['error']) {
         return [
            $images
         ];
      }

      return [
         "error" => false,
         "images" => $images
      ];
   }

   static public function getImageId($id)
   {
      $image = ImageModel::getImage($id);

      if (isset($image['error']) && $image['error']) {
         return [
            $image
         ];
      }

      return [
         "error" => false,
         "image" => $image
      ];
   }
}