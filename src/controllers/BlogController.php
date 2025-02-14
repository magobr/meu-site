<?php

namespace Controller;

use Model\PostsModel;

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;
use Ramsey\Uuid\Uuid;

class BlogController extends PostsModel
{
   static public function renderPosts()
   {
      $result = PostsModel::findPosts();

      if (isset($result['error']) && $result['error']) {
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
    

   static public function renderPost($id)
   {
      $request = new Request;

      $url = $request->getUrl();
      $url = explode("/", $url );

      $result = PostsModel::findPostsById($id);

      if (isset($result['error']) && $result['error']) {
         SimpleRouter::response()->json([
            $result
         ]);
      }

      if (sizeof($result) === 0) {
         SimpleRouter::response()->redirect('/not-found');
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

   static public function getPost($id)
   {
      $result = PostsModel::findPostsById($id);

      if (isset($result['error']) && $result['error']) {
         SimpleRouter::response()->httpCode(500)->json([
            "error" => true,
            "data" => $result,
            "message" => "Erro ao buscar dados"
        ]);
      }

      if (isset($result) && sizeof($result) === 0) {
         SimpleRouter::response()->httpCode(404)->json([
            "error" => false,
            "data" => $result,
            "message" => "Não foi encontrado dados"
        ]);
      }
      SimpleRouter::response()->httpCode(200)->json([
          "error" => false,
         "data" => $result
      ]);
   }

   static public function getPostByUser($id)
   {
      $result = PostsModel::findPostsByUser($id);

      if (isset($result['error']) && $result['error']) {
         SimpleRouter::response()->httpCode(500)->json([
            "error" => true,
            "data" => $result,
            "message" => "Erro ao buscar dados"
        ]);
      }

      if (sizeof($result) === 0) {
         SimpleRouter::response()->httpCode(404)->json([
            "error" => true,
            "data" => $result,
            "message" => "Não foi encontrado dados"
        ]);
      }

      SimpleRouter::response()->httpCode(200)->json([
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

      if (!isset($valores['image'])) {
         $valores['image'] = "";
      }

      $resp = PostsModel::storePost($valores);

      if (isset($resp["error"]) && $resp['error']) {
         SimpleRouter::response()->httpCode(500)->json([
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

      if (isset($resp["error"]) && $resp["error"]) {
         SimpleRouter::response()->httpCode(400)->json([
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

      if (isset($post['error']) && $post['error']) {
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