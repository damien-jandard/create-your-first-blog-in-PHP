<?php

use Controllers\HomeController;
use Controllers\UsersController;

require '../vendor/autoload.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case '':
        $controller = new HomeController();
        $controller->home();
        break;
    case 'register':
        $controller = new UsersController();
        $controller->register();
        break;
    case 'adduser':
        $controller = new UsersController();
        $controller->addUser();
        break;
    case 'login':
        $controller = new UsersController();
        $controller->login();
        break;
    default:
        echo "Route non définie";
        break;
}
