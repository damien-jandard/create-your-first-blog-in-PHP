<?php

namespace Controllers;

use Models\Entities\User;
use Models\Managers\UsersManager;

class UsersController
{
    use \App\Mailer;

    public function register()
    {
        include
            '../views/register.php';
    }

    public function addUser()
    {
        if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = htmlspecialchars($_POST['email']);
            if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
                if ($_POST['password'] === $_POST['confirmPassword']) {
                    $password = htmlspecialchars($_POST['password']);
                    $uppercase = preg_match('@[A-Z]@', $password);
                    $lowercase = preg_match('@[a-z]@', $password);
                    $number    = preg_match('@[0-9]@', $password);
                    $specialChars = preg_match('@[^\w]@', $password);
                    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                        $redirectTo = "?action=register&error=4&email=$email";
                    } else {
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        $token = bin2hex(openssl_random_pseudo_bytes(16));
                        $userManager = new UsersManager();
                        if ($userManager->checkUser($email) === false) {
                            $user = new User(['email' => $email, 'password' => $password, 'token' => $token]);
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
                        } else {
                            $redirectTo = "?action=register&error=5&email=$email";
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

    public function registered()
    {
        if (!empty($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) && !empty($_GET['token'])) {
            $email = htmlspecialchars($_GET['email']);
            $token = htmlspecialchars($_GET['token']);
            $user = new User(['email' => $email, 'token' => $token]);
            $userManager = new UsersManager();
            $userManager->registered($user);
            $redirectTo = "?action=login&activate=checked";
        } else {
            $redirectTo = "?";
        }
        header("Location: $redirectTo");
        exit;
    }

    public function login()
    {
        include '../views/login.php';
    }

    public function postLogin()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $userManager = new UsersManager();
            $user = $userManager->getUser($email);
            if ($user) {
                if ($user->checkPassword($password)) {
                    session_start();
                    $_SESSION['auth'] = true;
                    $_SESSION['isAdmin'] = $user->isAdmin();
                    $_SESSION['id'] = $user->id();
                    if ($user->isAdmin()) {
                        $redirectTo = "?action=dashboard";
                    } else {
                        $redirectTo =  "http://blog.test";
                    }
                } else {
                    $redirectTo = "?action=login&authentication=failed&email=$email";
                }
            } else {
                $redirectTo = "?action=login&authentication=failed";
            }
        } else {
            $redirectTo = "?action=login&authentication=empty";
        }
        header("Location: $redirectTo");
        exit;
    }

    public function dashboard()
    {
        session_start();
        if ($_SESSION['isAdmin']) {
            include '../views/dashboard.php';
        } else {
            $redirectTo = "?action=error&message=403";
            header("Location: $redirectTo");
            exit;
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: http://blog.test');
    }
}
