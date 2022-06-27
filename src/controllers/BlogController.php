<?php

namespace Blog\Controller;

require_once __DIR__.'/../model/PostsModel.php';

use Posts\Model\PostsModel;
use Pecee\SimpleRouter\SimpleRouter;


class BlogController extends PostsModel
{
   static public function getPosts()
   {
      $result = PostsModel::findPosts();

      if ($result['error']) {
         SimpleRouter::response()->json([
            $result
         ]);
      }

      if (sizeof($result) === 0) {
         SimpleRouter::response()->json([
            "error" => false,
            "data" => $result,
            "message" => "Não foi encontrado dados"
         ]);
      }

      SimpleRouter::response()->json([
         "error" => false,
         "data" => $result
      ]);
   }
    

   static public function getPost($id)
   {
      $result = PostsModel::findPostsById($id);

      if ($result['error']) {
         SimpleRouter::response()->json([
            $result
         ]);
      }

      if (sizeof($result) === 0) {
         SimpleRouter::response()->json([
            "error" => false,
            "data" => $result,
            "message" => "Não foi encontrado dados"
         ]);
      }

      SimpleRouter::response()->json([
         "error" => false,
         "data" => $result
      ]);
   }

   static public function getPostByUser($id)
   {
      $result = PostsModel::findPostsByUser($id);

      if ($result['error']) {
         SimpleRouter::response()->json([
            $result
         ]);
      }

      if (sizeof($result) === 0) {
         SimpleRouter::response()->json([
            "error" => false,
            "data" => $result,
            "message" => "Não foi encontrado dados"
         ]);
      }

      SimpleRouter::response()->json([
         "error" => false,
         "data" => $result
      ]);
   }
}