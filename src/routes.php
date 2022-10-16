<?php

require_once __DIR__.'/controllers/ViewController.php';
require_once __DIR__.'/controllers/BlogController.php';
require_once __DIR__.'/controllers/UserController.php';
require_once __DIR__.'/middleware/AuthMiddleware.php';
require_once __DIR__.'/controllers/AdminController.php';

use Admin\Controller\AdminController;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use View\Controller\ViewController;
use Blog\Controller\BlogController;
use User\Controller\UserController;
use Auth\Middleware\Auth;

// Render Pages
SimpleRouter::get('/', [ViewController::class, "renderPage"]);
SimpleRouter::get('/blog', [BlogController::class, "getPosts"]);
SimpleRouter::get('/blog/{id}', [BlogController::class, "getPost", $params]);

// Blogs Api
SimpleRouter::get('/blog/posts/{id}', [BlogController::class, "getPost", $params]);
SimpleRouter::get('/blog/posts/user/{id}', [BlogController::class, "getPostByUser", $params]);
SimpleRouter::post('/post/new', [BlogController::class, "insertPost"]);
SimpleRouter::delete('/post/delete/{id}', [BlogController::class, "purgePost", $params]);

// Users Api
SimpleRouter::post('/user/new', [UserController::class, "insertUser"]);
SimpleRouter::post('/user/login', [UserController::class, "login"]);
SimpleRouter::get('/user/logout', [UserController::class, "logout"]);

// AdminPages
SimpleRouter::group(["middleware" => Auth::class, "prefix" => "/admin"], function ()
{
    SimpleRouter::get('/', [ViewController::class, "renderLogin"]);
    SimpleRouter::get('/posts', [AdminController::class, "renderUserPosts"]);
});

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
            SimpleRouter::response()->json([
                "error" => $exception->getMessage()
            ]);
            // SimpleRouter::response()->redirect('/forbidden');
    }
    
});