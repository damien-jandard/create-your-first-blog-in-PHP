<?php

namespace Controllers;

use Models\Entities\User;
use Models\Managers\UsersManager;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
                        $token = bin2hex(openssl_random_pseudo_bytes(16));
                        $user = new User(['email' => $email, 'password' => $password, 'token' => $token]);
                        $userManager = new UsersManager();
                        $userManager->register($user);
                        $mailToUser = $this->sendEmail($email, $token);
                        if ($mailToUser === 'Email envoyé') {
                            $redirectTo = "index.php?action=login&activate=check";
                        } else {
                            $redirectTo = "index.php?action=error&message=user";
                        }
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

    public function sendEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        try {

            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = 'localhost';
            $mail->Port       = 1025;
            $mail->CharSet = "utf-8";
            $mail->setFrom('contact@blog.com', 'Blog PHP');
            $mail->addAddress($email);               //Name is optional
            $mail->addReplyTo('contact@blog.com', 'Contact');
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Activation de compte Blog PHP';
            //$mail->Body    = 'Bonjour <br>Merci pour votre inscription, afin de valider votre compte merci de cliquer sur ce <a href="http://blog.test?action=accountvalidation&email=' . $email . '&token=' . $token . '">lien</a>';
            ob_start();
            $url = "http://blog.test/index.php?action=registered&email=$email&token=$token";
            include '../views/email.php';
            $body = ob_get_clean();
            $mail->msgHTML($body);
            $mail->send();
            return 'Email envoyé';
        } catch (Exception $e) {
            return "Email non envoyé. Erreur: {$mail->ErrorInfo}";
        }
    }

    public function registered()
    {
        if (isset($_GET['email']) && !empty($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) !== false && isset($_GET['token']) && !empty($_GET['token'])) {
            $email = strip_tags($_GET['email']);
            $token = strip_tags($_GET['token']);
            $user = new User(['email' => $email, 'token' => $token]);
            $userManager = new UsersManager();
            $userManager->registered($user);
            $redirectTo = "index.php?action=login&activate=checked";
        } else {
            $redirectTo = "index.php";
        }
        header("Location: $redirectTo");
    }
}
