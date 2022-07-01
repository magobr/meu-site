<?php

namespace Blog\Controller;

require_once __DIR__.'/../model/PostsModel.php';

use Posts\Model\PostsModel;
use Pecee\SimpleRouter\SimpleRouter;
use Ramsey\Uuid\Uuid;

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

   static public function insertPost()
   {
      $arrInput = json_decode(file_get_contents('php://input'));
      $userUuid = Uuid::uuid4();
      $arrInput->{"id"}=$userUuid->toString();

      $valores = get_object_vars($arrInput);

      $resp = PostsModel::storePost($valores);

      if ($resp["error"]) {
         SimpleRouter::response()->httpCode(200)->json([
            $resp
        ]);
      }

      SimpleRouter::response()->httpCode(201)->json([
         "error" => false,
         "Message" => "Post publicado com sucesso"
     ]);
   }

   static public function purgePost($id)
   {
      $post = PostsModel::findPostsById($id);

      if ($post['error']) {
         SimpleRouter::response()->json([
            $post
         ]);
      }
      
      if (sizeof($post) === 0) {
         SimpleRouter::response()->json([
            "error" => false,
            "data" => $post,
            "message" => "Não foi encontrado dados"
         ]);
      }
      
      $result = PostsModel::deletePost($id);

      if ($result > 0) {
         SimpleRouter::response()->httpCode(202)->json([
            "error" => false,
            "Message" => "Post deletado com sucesso"
         ]);
      }
      
   }
}