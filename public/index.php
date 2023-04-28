<?php

use Controllers\HomeController;
use Controllers\UsersController;

require '../vendor/autoload.php';

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
        $controller = new UsersController();
        $controller->dashboard();
        break;
    case 'logout':
        $controller = new UsersController();
        $controller->logout();
        break;
    default:
        include '../views/error.php';
        break;
}
