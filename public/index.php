<?php

use Controllers\HomeController;

require '../vendor/autoload.php';

$action = $_GET[''] ?? '';

switch ($action) {
    case '':
        $controller = new HomeController();
        $controller->home();
        break;
    default:
        echo "Route non définie";
        break;
}
