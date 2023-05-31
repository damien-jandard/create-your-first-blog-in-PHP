<?php

namespace Controllers;

use App\PHPSession;
use Models\Managers\PostsManager;

class HomeController extends Controller
{
    use \App\Mailer;

    private $postManager;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->postManager = new PostsManager();
        $this->session = new PHPSession();
    }

    public function home()
    {
        $posts = $this->postManager->findAllPost(true, 3);
        $success = $this->session->get('success');
        $failure = $this->session->get('failure');
        return $this->render(
            'home/home.html.twig',
            compact('posts', 'success', 'failure')
        );
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
                        $this->render(
                            'email/contact.html.twig',
                            compact('name', 'email', 'message')
                        );
                        $body = ob_get_clean();
                        $mailToAdmin = $this->sendEmail(
                            'Prise de contact',
                            $email,
                            'contact@blog.com',
                            $body
                        );
                        if ($mailToAdmin === 'Email envoyé') {
                            $this->session->set(
                                'success',
                                'Merci pour votre prise de contact je reviendrais vers vous dès que possible.'
                            );
                            $redirectTo = "?#contact";
                        } else {
                            $this->session->set(
                                'error',
                                $mailToAdmin
                            );
                            $redirectTo = "?action=error";
                        }
                    } else {
                        $this->session->set(
                            'failure',
                            'Merci de saisir un message compris entre 10 et 255 caractères.'
                        );
                        $redirectTo = "?name=$name&email=$email&message=$message#contact";
                    }
                } else {
                    $this->session->set(
                        'failure',
                        'Merci de saisir un message compris entre 10 et 255 caractères.'
                    );
                    $redirectTo = "?name=$name&email=$email#contact";
                }
            } else {
                $this->session->set(
                    'failure',
                    'Merci de saisir une adresse email valide.'
                );
                $redirectTo = "?name=$name#contact";
            }
        } else {
            $this->session->set(
                'failure',
                'Merci de saisir votre nom.'
            );
            $redirectTo = "?#contact";
        }
        $this->redirectTo($redirectTo);
    }
}
