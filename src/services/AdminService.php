<?php

namespace Service;

use Model\PostsModel;

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
}