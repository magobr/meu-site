<?php

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;

use Controller\AdminController;
use Controller\ViewController;
use Controller\BlogController;
use Controller\ImageController;
use Controller\UserController;
use Middleware\Auth;
use Middleware\UserAccessAdmin;
use Middleware\UserAccessWriter;

// Render Pages
SimpleRouter::get('/', [ViewController::class, "renderPage"]);
SimpleRouter::get('/blog', [BlogController::class, "getPosts"]);
SimpleRouter::get('/blog/{id}', [BlogController::class, "getPost", $params='']);

// Blogs Api
SimpleRouter::get('/blog/posts/{id}', [BlogController::class, "getPost", $params='']);
SimpleRouter::get('/blog/posts/user/{id}', [BlogController::class, "getPostByUser", $params='']);
SimpleRouter::put('/posts/{id}', [BlogController::class, "updatePosts", $params='']);
SimpleRouter::post('/post/new', [BlogController::class, "insertPost"]);
SimpleRouter::delete('/post/delete/{id}', [BlogController::class, "purgePost", $params='']);

// Login
SimpleRouter::post('/user/login', [UserController::class, "login"]);
SimpleRouter::get('/user/logout', [UserController::class, "logout"]);

// Users Api
SimpleRouter::group(["middleware" => Auth::class, "prefix" => "/user"], function()
{
    SimpleRouter::post('/new', [UserController::class, "insertUser"]);
    SimpleRouter::put('/update/{id}', [UserController::class, "update", $params='']);
    SimpleRouter::put('/update/pass/{id}', [UserController::class, "updatePassword", $params='']);
    SimpleRouter::delete('/delete/{id}', [UserController::class, "delete", $params='']);
});

// Image Api
SimpleRouter::post('/image/new', [ImageController::class, "insertImage"]);

// AdminPages
SimpleRouter::group(["middleware" => Auth::class, "prefix" => "/admin"], function ()
{

    SimpleRouter::group(["middleware" => UserAccessWriter::class], function (){
        SimpleRouter::get('/posts/new', [AdminController::class, "renderNewPost"]);
        SimpleRouter::get('/posts/edit/{id}', [AdminController::class, "renderEditPosts", $params='']);
    });

    SimpleRouter::group(["middleware" => UserAccessAdmin::class], function (){
        SimpleRouter::get('/posts/delete/{id}', [AdminController::class, "renderDelPosts", $params='']);
    });

    SimpleRouter::get('/posts', [AdminController::class, "renderUserPosts"]);
    SimpleRouter::get('/', [ViewController::class, "renderLogin"]);
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