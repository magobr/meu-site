<?php

namespace Model;

use Config\Sql;

class PostsModel extends Sql
{
    static public function findPosts()
    {
        $data = [
            "table" => "POSTS",
            "campos" => "POSTS.id, DATE_FORMAT(POSTS.created_at, '%d/%m/%Y') AS created_at, POSTS.titulo, USER_POSTER.nome as user_post, POSTS_COVER.image",
            "params"=>"INNER JOIN USER_POSTER ON POSTS.user_post = USER_POSTER.id LEFT JOIN POSTS_COVER ON POSTS.image = POSTS_COVER.id ORDER BY POSTS.created_at DESC",
            "values" => []
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params'], $data['campos']);
    }

    static public function findPostsById($id)
    {
        $data =[
            "table" => "POSTS",
            "campos" => "POSTS.id, DATE_FORMAT(POSTS.created_at, '%d/%m/%Y') AS created_at, POSTS.titulo, POSTS.conteudo, USER_POSTER.nome AS user_post",
            "params"=> "INNER JOIN USER_POSTER ON POSTS.user_post = USER_POSTER.id WHERE POSTS.id = :id",
            "values" => [
                "id" => $id
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params'], $data['campos']);
    }

    static public function findPostsByUser($id)
    {
        $data =[
            "table" => "POSTS",
            "campos" => "POSTS.id, DATE_FORMAT(POSTS.created_at, '%d/%m/%Y') AS created_at, POSTS.titulo, USER_POSTER.nome as user_post",
            "params"=>"INNER JOIN USER_POSTER ON POSTS.user_post = USER_POSTER.id WHERE USER_POSTER.id = :id ORDER BY POSTS.created_at DESC;",
            "values" => [
                "id" => $id
            ]
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data["values"], $data['params'], $data['campos']);
    }

    static public function storePost($valores)
    {
        $data = [
            "table" => "POSTS",
            "campos" => "id, titulo, conteudo, user_post, image",
            "indexCampos" => ":id, :titulo, :conteudo, :user_post, :image",
            "valores" => $valores
        ];

        $sql = new Sql();
        return $sql->store($data['table'], $data['valores'], $data['campos'], $data['indexCampos']);
    }

    static public function updatePost($valores, $user_id)
    {
        $data = [
            "table" => "POSTS",
            "campos" => ["titulo", "conteudo"],
            "valores" => $valores,
            "indexCampos" => [":titulo", ":conteudo"],
            "params"=>"WHERE id = '$user_id';"
        ];

        $sql = new Sql();
        return $sql->updateItem($data['table'], $data['valores'], $data['campos'], $data['params'], $data["indexCampos"]);
    }

    static public function deletePost($id)
    {
        $data = [
            "table" => "POSTS",
            "params" => "id = :id",
        ];

        $sql = new Sql();
        return $sql->delItem($data["table"], ["id" => $id], $data["params"]);
    }
}