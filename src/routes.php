<?php

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;

use Controller\AdminController;
use Controller\ViewController;
use Controller\BlogController;
use Controller\ImageController;
use Controller\UserController;
use Controller\ProjetosController;
use Middleware\Auth;
use Middleware\Access;

// Render Pages
SimpleRouter::get('/', [ViewController::class, "renderPage"]);
SimpleRouter::get('/blog', [BlogController::class, "getPosts"]);
SimpleRouter::get('/blog/{id}', [BlogController::class, "getPost", $params='']);

// Blogs Api
SimpleRouter::get('/blog/posts/{id}', [BlogController::class, "getPost", $params='']);
SimpleRouter::get('/blog/posts/user/{id}', [BlogController::class, "getPostByUser", $params='']);

SimpleRouter::group(["prefix" => "/posts", "middleware" => Access::class], function ()
{
    SimpleRouter::post('/new', [BlogController::class, "insertPost"]);
    SimpleRouter::put('/edit/{id}', [BlogController::class, "updatePosts", $params='']);
    SimpleRouter::delete('/delete/{id}', [BlogController::class, "purgePost", $params='']);
});

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
    SimpleRouter::group(["middleware" => Access::class], function ()
    {
        SimpleRouter::get('/posts/new', [AdminController::class, "renderNewPost"]);
        SimpleRouter::get('/posts/edit/{id}', [AdminController::class, "renderEditPosts", $params='']);
        SimpleRouter::get('/posts/delete/{id}', [AdminController::class, "renderDelPosts", $params='']);
    });

    SimpleRouter::get('/posts', [AdminController::class, "renderUserPosts"]);
    SimpleRouter::get('/', [ViewController::class, "renderLogin"]);
});

// Projetos
SimpleRouter::group(["prefix" => "/projetos"], function()
{
    SimpleRouter::group(["prefix" => "/api"], function ()
    {
        SimpleRouter::get('/', [ProjetosController::class, "getProjetos"]);    
    });
    SimpleRouter::get('/', [ProjetosController::class, "renderUserProjetos"]);    
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