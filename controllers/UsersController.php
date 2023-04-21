<?php

namespace Controllers;

use Models\Entities\User;
use Models\Managers\UsersManager;

class UsersController
{
    public function register()
    {
        include '../views/register.php';
    }

    public function addUser()
    {
        if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false) {
            $email = strip_tags($_POST['email']);
            if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword'])) {
                if ($_POST['password'] === $_POST['confirmPassword']) {
                    $password = strip_tags($_POST['password']);
                    $uppercase = preg_match('@[A-Z]@', $password);
                    $lowercase = preg_match('@[a-z]@', $password);
                    $number    = preg_match('@[0-9]@', $password);
                    $specialChars = preg_match('@[^\w]@', $password);
                    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                        $redirectTo = "index.php?action=register&error=4&email=$email";
                    } else {
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        $user = new User(['email' => $email, 'password' => $password]);
                        $userManager = new UsersManager();
                        $userManager->register($user);
                        $redirectTo = "index.php?action=login";
                    }
                } else {
                    $redirectTo = "index.php?action=register&error=3&email=$email";
                }
            } else {
                $redirectTo = "index.php?action=register&error=2&email=$email";
            }
        } else {
            $redirectTo = "index.php?action=register&error=1";
        }
        header("Location: $redirectTo");
        exit;
    }

    public function login()
    {
        include '../views/login.php';
    }
}
