<?php

namespace Controller;

use Model\PostsModel;

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;
use Ramsey\Uuid\Uuid;

class BlogController extends PostsModel
{
   static public function getPosts()
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
    

   static public function getPost($id)
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

   static public function getPostsUser($id)
   {
      $result = PostsModel::findPostsByUser($id);

      if (isset($result['error']) && $result['error']) {
         return [
            $result
         ];
      }

      if (sizeof($result) === 0) {
         return[
            "error" => false,
            "data" => $result,
            "message" => "Não foi encontrado dados"
         ];
      }

      return[
         "error" => false,
         "data" => $result
      ];
   }

   static public function insertPost()
   {

      $arrInput = json_decode(file_get_contents('php://input'));
      if (empty($arrInput)) {
         SimpleRouter::response()->httpCode(400)->json([
            "error" => true,
            "Message" => "Requisição sem corpo"
        ]);
      }

      if (empty($arrInput->{"image"})) {
         $arrInput->{"image"} = NULL;
      }

      $userUuid = Uuid::uuid4();
      $arrInput->{"id"}=$userUuid->toString();

      $valores = get_object_vars($arrInput);
      
      if (empty($valores)) {
         SimpleRouter::response()->httpCode(400)->json([
            "error" => true,
            "Message" => "Requisição sem corpo"
        ]);
      }
      
      if (empty($valores['titulo'])) {
         SimpleRouter::response()->httpCode(200)->json([
            "error" => true,
            "Message" => "Preencha o campo título"
        ]);
      }

      if (empty($valores['conteudo'])) {
         SimpleRouter::response()->httpCode(200)->json([
            "error" => true,
            "Message" => "Preencha o campo conteudo"
        ]);
      }

      if (empty($valores['user_post'])) {
         SimpleRouter::response()->httpCode(200)->json([
            "error" => true,
            "Message" => "Faça autenticação para continuar"
        ]);
      }

      $resp = PostsModel::storePost($valores);

      if (isset($resp["error"]) && $resp['error']) {
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

      if (empty($valores)) {
         SimpleRouter::response()->httpCode(400)->json([
            "error" => true,
            "Message" => "Requisição sem corpo"
        ]);
      }

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