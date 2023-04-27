<?php

namespace Controllers;

use Models\Entities\User;
use Models\Managers\UsersManager;

class UsersController
{
    use \App\Mailer;

    public function register()
    {
        include '../views/register.php';
    }

    public function addUser()
    {
        if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = strip_tags($_POST['email']);
            if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
                if ($_POST['password'] === $_POST['confirmPassword']) {
                    $password = strip_tags($_POST['password']);
                    $uppercase = preg_match('@[A-Z]@', $password);
                    $lowercase = preg_match('@[a-z]@', $password);
                    $number    = preg_match('@[0-9]@', $password);
                    $specialChars = preg_match('@[^\w]@', $password);
                    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                        $redirectTo = "?action=register&error=4&email=$email";
                    } else {
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        $token = bin2hex(openssl_random_pseudo_bytes(16));
                        $user = new User(['email' => $email, 'password' => $password, 'token' => $token]);
                        $userManager = new UsersManager();
                        $userManager->register($user);
                        ob_start();
                        $url = "http://blog.test/?action=registered&email=$email&token=$token";
                        include '../views/email.php';
                        $body = ob_get_clean();
                        $mailToUser = $this->sendEmail('Activation de compte Blog PHP', $email, 'contact@blog.com', $body);
                        if ($mailToUser === 'Email envoyé') {
                            $redirectTo = "?action=login&activate=check";
                        } else {
                            $redirectTo = "?action=error&message=" . $mailToUser;
                        }
                    }
                } else {
                    $redirectTo = "?action=register&error=3&email=$email";
                }
            } else {
                $redirectTo = "?action=register&error=2&email=$email";
            }
        } else {
            $redirectTo = "?action=register&error=1";
        }
        header("Location: $redirectTo");
        exit;
    }

    public function login()
    {
        include '../views/login.php';
    }

    public function registered()
    {
        if (!empty($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) && !empty($_GET['token'])) {
            $email = strip_tags($_GET['email']);
            $token = strip_tags($_GET['token']);
            $user = new User(['email' => $email, 'token' => $token]);
            $userManager = new UsersManager();
            $userManager->registered($user);
            $redirectTo = "?action=login&activate=checked";
        } else {
            $redirectTo = "";
        }
        header("Location: $redirectTo");
        exit;
    }
}
