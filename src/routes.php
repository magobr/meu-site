<?php

require_once __DIR__.'/controllers/ViewController.php';
require_once __DIR__.'/controllers/BlogController.php';

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use View\Controller\ViewController;
use Blog\Controller\BlogController;

// Render Pages
SimpleRouter::get('/', [ViewController::class, "renderPage"]);
SimpleRouter::get('/blog', [ViewController::class, "renderBlog"]);

// Blogs
SimpleRouter::get('/blog/posts', [BlogController::class, "getPosts"]);
SimpleRouter::get('/blog/posts/{id}', [BlogController::class, "getPost", $params]);
SimpleRouter::get('/blog/posts/user/{id}', [BlogController::class, "getPostByUser", $params]);

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