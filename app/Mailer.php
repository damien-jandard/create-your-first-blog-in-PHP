<?php

namespace App;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

trait Mailer
{
    public function sendEmail($subject, $email, $replyTo, $body)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = 'localhost';
            $mail->Port       = 1025;
            $mail->CharSet = "utf-8";
            $mail->setFrom('contact@blog.com', 'Blog PHP');
            $mail->addAddress($email);
            $mail->addReplyTo($replyTo);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->msgHTML($body);
            $mail->send();
            return 'Email envoyé';
        } catch (Exception $e) {
            return "Email non envoyé. Erreur: {$mail->ErrorInfo}";
        }
    }
}
