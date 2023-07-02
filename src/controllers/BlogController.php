<?php

namespace Blog\Controller;

require_once __DIR__.'/../model/PostsModel.php';

use Posts\Model\PostsModel;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
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
        
      $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
      $twig = new \Twig\Environment($loader);

      $template = $twig->load('pages/blogs.twig');
      echo $template->render([
         "error" => false,
         "data" => $result
      ]);
      return;
   }
    

   static public function getPost($id)
   {
      $request = new Request;

      $url = $request->getUrl();
      $url = explode("/", $url );

      $result = PostsModel::findPostsById($id);

      if ($result['error']) {
         SimpleRouter::response()->json([
            $result
         ]);
      }

      if (sizeof($result) === 0) {
         SimpleRouter::response()->redirect('/not-found');
      }

      
      if(in_array("admin", $url)){
         return $result;
      }

      $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../view');
      $twig = new \Twig\Environment($loader);

      $template = $twig->load('pages/post.twig');
      echo $template->render([
         "error" => false,
         "data" => $result
      ]);
      return;
   }

   static public function getPostByUser($id)
   {
      $result = PostsModel::findPostsByUser($id);

      if (isset($result['error'])) {
         return [
            $result
         ];
      }

      if (sizeof($result) === 0) {
         return [
            "error" => false,
            "data" => $result,
            "message" => "Não foi encontrado dados"
         ];
      }

      return [
         "error" => false,
         "data" => $result
      ];
   }

   static public function insertPost()
   {
      $arrInput = json_decode(file_get_contents('php://input'));
      $userUuid = Uuid::uuid4();
      $arrInput->{"id"}=$userUuid->toString();

      $valores = get_object_vars($arrInput);

      if ($valores['titulo'] === "") {
         SimpleRouter::response()->httpCode(200)->json([
            "error" => true,
            "Message" => "Preencha o campo título"
        ]);
      }

      if ($valores['conteudo'] === "") {
         SimpleRouter::response()->httpCode(200)->json([
            "error" => true,
            "Message" => "Preencha o campo conteudo"
        ]);
      }

      $resp = PostsModel::storePost($valores);

      if ($resp["error"]) {
         SimpleRouter::response()->httpCode(200)->json([
            $resp
        ]);
      }

      SimpleRouter::response()->httpCode(201)->json([
         "error" => false,
         "Message" => "Post publicado com sucesso",
         "id" => $userUuid
      ]);
   }

   static public function updatePosts($id)
   {
      $arrInput = json_decode(file_get_contents('php://input'));

      $valores = get_object_vars($arrInput);

      if ($valores['titulo'] === "") {
         SimpleRouter::response()->httpCode(200)->json([
            "error" => true,
            "Message" => "Preencha o campo título"
        ]);
      }

      if ($valores['conteudo'] === "") {
         SimpleRouter::response()->httpCode(200)->json([
            "error" => true,
            "Message" => "Preencha o campo conteudo"
        ]);
      }
      
      $resp = PostsModel::updatePost($valores,$id);

      if ($resp["error"]) {
         SimpleRouter::response()->httpCode(200)->json([
            $resp
        ]);
      }

      SimpleRouter::response()->httpCode(201)->json([
         "error" => false,
         "Message" => "Post atualizado com sucesso"
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