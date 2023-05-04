<?php

namespace Controllers;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends Controller
{
    use \App\Mailer;

    public function home()
    {
        return $this->render('home.html.twig');
    }

    public function contact()
    {
        if (!empty($_POST['name'])) {
            $name = strip_tags($_POST['name']);
            if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email = strip_tags($_POST['email']);
                if (!empty($_POST['message'])) {
                    $message = strip_tags($_POST['message']);
                    if (strlen($message) >= 10 && strlen($message) < 255) {
                        ob_start();
                        $this->render('email/contact.html.twig', ['name' => $name, 'email' => $email, 'message' => $message]);
                        $body = ob_get_clean();
                        $mailToAdmin = $this->sendEmail('Prise de contact', $email, 'contact@blog.com', $body);
                        if ($mailToAdmin === 'Email envoyé') {
                            $redirectTo = "?status=ended#contact";
                        } else {
                            $redirectTo = "?action=error&message=" . $mailToAdmin;
                        }
                    } else {
                        $redirectTo = "?status=message&name=$name&email=$email&message=$message#contact";
                    }
                } else {
                    $redirectTo = "?status=message&name=$name&email=$email#contact";
                }
            } else {
                $redirectTo = "?status=email&name=$name#contact";
            }
        } else {
            $redirectTo = "?status=name#contact";
        }
        header("Location: $redirectTo");
        exit;
    }
}
