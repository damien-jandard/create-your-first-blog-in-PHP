<?php

namespace Controllers;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController
{
    public function home()
    {
        include '../views/home.php';
    }

    public function contact()
    {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $name = strip_tags($_POST['name']);
            if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false) {
                $email = strip_tags($_POST['email']);
                if (isset($_POST['message']) && !empty($_POST['message'])) {
                    $message = strip_tags($_POST['message']);
                    if (strlen($message) >= 10 && strlen($message) < 255) {
                        $mail = new PHPMailer(true);
                        try {

                            $mail->SMTPDebug = SMTP::DEBUG_OFF;
                            $mail->isSMTP();
                            $mail->Host       = 'localhost';
                            $mail->Port       = 1025;
                            $mail->CharSet = "utf-8";
                            $mail->setFrom('contact@blog.com', 'Contact blog PHP');
                            $mail->addAddress('contact@blog.com');               //Name is optional
                            $mail->addReplyTo('contact@blog.com', 'Contact');
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Prise de contact';
                            ob_start();
                            include '../views/contact.php';
                            $body = ob_get_clean();
                            $mail->msgHTML($body);
                            $mail->send();
                            $redirectTo = "?status=ended#contact";
                        } catch (Exception $e) {
                            echo "Email non envoyé. Erreur: {$mail->ErrorInfo}";
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
