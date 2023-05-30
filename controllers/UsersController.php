<?php

namespace Controllers;

use App\PHPSession;
use Models\Entities\User;
use Models\Managers\CommentsManager;
use Models\Managers\PostsManager;
use Models\Managers\UsersManager;

class UsersController extends Controller
{
    use \App\Mailer;

    private $userManager;
    private $postManager;
    private $commentManager;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UsersManager();
        $this->postManager = new PostsManager();
        $this->commentManager = new CommentsManager();
        $this->session = new PHPSession();
    }

    public function register()
    {
        $success = $this->session->get('success');
        $failure = $this->session->get('failure');
        return $this->render(
            'users/register.html.twig',
            compact('success', 'failure')
        );
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
                        $this->session->set(
                            'failure',
                            'Votre mot de passe ne respecte pas les règles de sécurité.'
                        );
                        $redirectTo = "?action=register&email=$email";
                    } else {
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        $token = bin2hex(openssl_random_pseudo_bytes(16));
                        if ($this->userManager->checkUser($email) === false) {
                            $user = new User([
                                'email' => $email,
                                'password' => $password,
                                'token' => $token
                            ]);
                            $this->userManager->register($user);
                            ob_start();
                            $url = "http://blog.test/?action=registered&email=$email&token=$token";
                            $this->render(
                                'email/activation.html.twig',
                                compact('url')
                            );
                            $body = ob_get_clean();
                            $mailToUser = $this->sendEmail(
                                'Activation de compte Blog PHP',
                                $email,
                                'contact@blog.com',
                                $body
                            );
                            if ($mailToUser === 'Email envoyé') {
                                $this->session->set(
                                    'success',
                                    'Merci pour votre inscription. Activez votre compte via le lien envoyé par email.'
                                );
                                $redirectTo = "?action=login";
                            } else {
                                $this->session->set(
                                    'failure',
                                    $mailToUser
                                );
                                $redirectTo = "?action=error";
                            }
                        } else {
                            $this->session->set(
                                'failure',
                                'Un compte existe déjà pour cette adresse email.'
                            );
                            $redirectTo = "?action=register&email=$email";
                        }
                    }
                } else {
                    $this->session->set(
                        'failure',
                        'Les mots de passes ne sont pas identiques.'
                    );
                    $redirectTo = "?action=register&email=$email";
                }
            } else {
                $this->session->set(
                    'failure',
                    'Merci de saisir un mot de passe.'
                );
                $redirectTo = "?action=register&email=$email";
            }
        } else {
            $this->session->set(
                'failure',
                'Adresse email non valide.'
            );
            $redirectTo = "?action=register";
        }
        $this->redirectTo($redirectTo);
    }

    public function registered()
    {
        if (!empty($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) && !empty($_GET['token'])) {
            $email = htmlspecialchars($_GET['email']);
            $token = htmlspecialchars($_GET['token']);
            $user = new User([
                'email' => $email,
                'token' => $token
            ]);
            $this->userManager->registered($user);
            $this->session->set(
                'success',
                'Votre compte est désormais activé. Vous pouvez dès à présent vous connecter.'
            );
            $redirectTo = "?action=login";
        } else {
            $redirectTo = "?";
        }
        $this->redirectTo($redirectTo);
    }

    public function login()
    {
        $success = $this->session->get('success');
        $failure = $this->session->get('failure');
        return $this->render(
            'users/login.html.twig',
            compact('success', 'failure')
        );
    }

    public function postLogin()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->userManager->getUser($email);
            if ($user) {
                if ($user->checkPassword($password)) {
                    $_SESSION['auth'] = true;
                    $_SESSION['isAdmin'] = $user->isAdmin();
                    $_SESSION['email'] = $user->email();
                    $_SESSION['id'] = $user->id();
                    if ($user->isAdmin()) {
                        $redirectTo = "?action=dashboard";
                    } else {
                        $redirectTo =  "?";
                    }
                } else {
                    $this->session->set(
                        'failure',
                        'Utilisateur ou mot de passe incorrect.'
                    );
                    $redirectTo = "?action=login&email=$email";
                }
            } else {
                $this->session->set(
                    'failure',
                    'Utilisateur ou mot de passe incorrect.'
                );
                $redirectTo = "?action=login";
            }
        } else {
            $this->session->set(
                'failure',
                'Les champs ne peuvent pas être vide.'
            );
            $redirectTo = "?action=login";
        }
        $this->redirectTo($redirectTo);
    }

    public function dashboard()
    {
        $posts = $this->postManager->findAllPost();
        $comments = $this->commentManager->findAllPendingComments();
        $success = $this->session->get('success');
        $failure = $this->session->get('failure');
        return $this->render(
            'users/dashboard.html.twig',
            compact('posts', 'comments', 'success', 'failure')
        );
    }

    public function logout()
    {
        $_SESSION = [];
        session_unset();
        session_destroy();
        $redirectTo = '?';
        $this->redirectTo($redirectTo);
    }
}
