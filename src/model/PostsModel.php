<?php

namespace Posts\Model;

require_once __DIR__.'/../config/Conn.php';

use Sql;

class PostsModel extends Sql
{
    static public function findPosts()
    {
        $data =[
            "table" => "POSTS",
            "campos" => "POSTS.id, DATE_FORMAT(POSTS.created_at, '%d/%m/%Y') AS created_at, POSTS.titulo, POSTS.conteudo, USER_POSTER.nome as user_post",
            "params"=>"INNER JOIN USER_POSTER ON POSTS.user_post = USER_POSTER.id"
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data['params'], $data['campos']);
    }

    static public function findPostsById($id)
    {
        $data =[
            "table" => "POSTS",
            "campos" => "POSTS.id, DATE_FORMAT(POSTS.created_at, '%d/%m/%Y') AS created_at, POSTS.titulo, POSTS.conteudo, USER_POSTER.nome AS user_post",
            "params"=>"INNER JOIN USER_POSTER ON POSTS.user_post = USER_POSTER.id WHERE POSTS.id = '$id'"
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data['params'], $data['campos']);
    }

    static public function findPostsByUser($id)
    {
        $data =[
            "table" => "POSTS",
            "params"=>"INNER JOIN USER_POSTER ON POSTS.user_post = USER_POSTER.id WHERE USER_POSTER.id = '$id'"
        ];

        $sql = new Sql();
        return $sql->find($data['table'], $data['params']);
    }
}