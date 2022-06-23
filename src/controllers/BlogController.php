<?php

namespace Blog\Controller;

require_once __DIR__.'/../model/PostsModel.php';

use Posts\Model\PostsModel;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;


class BlogController extends PostsModel
{
    static public function getPosts()
    {
      $result = PostsModel::findPosts();
      $data = [];

      if (sizeof($result) === 0) {
         $data = [
            "error" => true,
            "message" => "Não foi encontrado dados"
         ];

         $data = json_encode($data);
         return $data;
      }

      $data = [
         "error" => false,
         "data" => $result,
      ];

      $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
      return $data;
    }
    

    static public function getPost($id)
    {
      $result = PostsModel::findPostsById($id);
      $data = [];

      if (sizeof($result) === 0) {
         $data = [
            "error" => true,
            "message" => "Não foi encontrado dados"
         ];
         return json_encode($data);
      }

      $data = [
         "error" => false,
         "data" => $result,
      ];

      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }

    static public function getPostByUser($id)
    {
      $result = PostsModel::findPostsByUser($id);
      $data = [];

      if (sizeof($result) === 0) {
         $data = [
            "error" => true,
            "message" => "Não foi encontrado dados"
         ];
         return json_encode($data);
      }

      $data = [
         "error" => false,
         "data" => $result
      ];

      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }
}