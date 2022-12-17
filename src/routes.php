<?php

require_once __DIR__.'/controllers/ViewController.php';
require_once __DIR__.'/controllers/BlogController.php';
require_once __DIR__.'/controllers/ImageController.php';
require_once __DIR__.'/controllers/UserController.php';
require_once __DIR__.'/middleware/AuthMiddleware.php';
require_once __DIR__.'/controllers/AdminController.php';

use Admin\Controller\AdminController;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use View\Controller\ViewController;
use Blog\Controller\BlogController;
use Blog\Controller\ImageController;
use User\Controller\UserController;
use Auth\Middleware\Auth;

// Render Pages
SimpleRouter::get('/', [ViewController::class, "renderPage"]);
SimpleRouter::get('/blog', [BlogController::class, "getPosts"]);
SimpleRouter::get('/blog/{id}', [BlogController::class, "getPost", $params]);

// Blogs Api
SimpleRouter::get('/blog/posts/{id}', [BlogController::class, "getPost", $params]);
SimpleRouter::get('/blog/posts/user/{id}', [BlogController::class, "getPostByUser", $params]);
SimpleRouter::put('/posts/{id}', [BlogController::class, "updatePosts", $params]);
SimpleRouter::post('/post/new', [BlogController::class, "insertPost"]);
SimpleRouter::delete('/post/delete/{id}', [BlogController::class, "purgePost", $params]);

// Users Api
SimpleRouter::post('/user/new', [UserController::class, "insertUser"]);
SimpleRouter::post('/user/login', [UserController::class, "login"]);
SimpleRouter::get('/user/logout', [UserController::class, "logout"]);

// Image Api
SimpleRouter::post('/image/new', [ImageController::class, "insertImage"]);

// AdminPages
SimpleRouter::group(["middleware" => Auth::class, "prefix" => "/admin"], function ()
{
    SimpleRouter::get('/posts', [AdminController::class, "renderUserPosts"]);
    SimpleRouter::get('/posts/edit/{id}', [AdminController::class, "renderEditPosts", $params='']);
    SimpleRouter::get('/posts/delete/{id}', [AdminController::class, "renderDelPosts", $params='']);
    SimpleRouter::get('/posts/new', [AdminController::class, "renderNewPost"]);
    SimpleRouter::get('/', [ViewController::class, "renderLogin"])->name("admin");
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
            SimpleRouter::response()->redirect('/forbidden');
    }
    
});