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
    default:
        include '../views/error.php';
        break;
}
