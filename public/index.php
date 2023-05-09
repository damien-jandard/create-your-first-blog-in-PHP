<?php

use Controllers\ErrorController;
use Controllers\HomeController;
use Controllers\PostsController;
use Controllers\UsersController;
use Middlewares\AdminMiddleware;

require '../vendor/autoload.php';

session_start();

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}

function camel_to_snake($input)
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
}

function snakeToCamel($input)
{
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case '':
        $controller = new HomeController();
        $controller->home();
        break;
    case 'contact':
        $controller = new HomeController();
        $controller->contact();
        break;
    case 'register':
        $controller = new UsersController();
        $controller->register();
        break;
    case 'adduser':
        $controller = new UsersController();
        $controller->addUser();
        break;
    case 'registered':
        $controller = new UsersController();
        $controller->registered();
        break;
    case 'login':
        $controller = new UsersController();
        $controller->login();
        break;
    case 'postlogin':
        $controller = new UsersController();
        $controller->postLogin();
        break;
    case 'dashboard':
        $middleware = new AdminMiddleware();
        $middleware->checkAllowed();
        $controller = new UsersController();
        $controller->dashboard();
        break;
    case 'logout':
        $controller = new UsersController();
        $controller->logout();
        break;
    case 'newpost':
        $middleware = new AdminMiddleware();
        $middleware->checkAllowed();
        $controller = new PostsController();
        $controller->newPost();
        break;
    case 'addpost':
        $middleware = new AdminMiddleware();
        $middleware->checkAllowed();
        $controller = new PostsController();
        $controller->addPost();
        break;
    default:
        $controller = new ErrorController();
        $controller->error();
        break;
}
