<?php

require_once __DIR__.'/controllers/ViewController.php';
require_once __DIR__.'/controllers/BlogController.php';
require_once __DIR__.'/controllers/UserController.php';

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use View\Controller\ViewController;
use Blog\Controller\BlogController;
use User\Controller\UserController;

// Render Pages
SimpleRouter::get('/', [ViewController::class, "renderPage"]);
SimpleRouter::get('/blog', [ViewController::class, "renderBlog"]);

// Blogs Api
SimpleRouter::get('/blog/posts', [BlogController::class, "getPosts"]);
SimpleRouter::get('/blog/posts/{id}', [BlogController::class, "getPost", $params]);
SimpleRouter::get('/blog/posts/user/{id}', [BlogController::class, "getPostByUser", $params]);
SimpleRouter::post('/post/new', [BlogController::class, "insertPost"]);
SimpleRouter::delete('/post/delete/{id}', [BlogController::class, "purgePost", $params]);

// Users Api
SimpleRouter::post('/user/new', [UserController::class, "insertUser"]);

// error pages
SimpleRouter::get('/not-found', [ViewController::class, "errorPage"]);
SimpleRouter::get('/forbidden', [ViewController::class, "forbiddenPage"]);


SimpleRouter::error(function(Request $request, \Exception $exception) {

    switch($exception->getCode()) {
        // Page not found
        case 404:
            SimpleRouter::response()->redirect('/not-found');
        // Forbidden
        case 403:
            SimpleRouter::response()->redirect('/forbidden');
    }
    
});