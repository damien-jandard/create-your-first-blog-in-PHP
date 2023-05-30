<?php

namespace Controllers;

use App\PHPSession;
use Models\Entities\Comment;
use Models\Managers\CommentsManager;
use Models\Managers\PostsManager;
use Models\Managers\UsersManager;

class CommentsController extends Controller
{
    private $commentManager;
    private $userManager;
    private $postManager;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentsManager();
        $this->userManager = new UsersManager();
        $this->postManager = new PostsManager();
        $this->session = new PHPSession();
    }

    public function defineStatusComment()
    {
        if (!empty($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $comment = $this->commentManager->getComment($id);
            if ($_GET['action'] === 'approvecomment') {
                $status = true;
                $this->session->set(
                    'success',
                    'Le commentaire a été approuvé et est désormais rendu public'
                );
            } else {
                $status = false;
                $this->session->set(
                    'failure',
                    'Le commentaire a été refusé et ne sera pas rendu public'
                );
            }
            $comment->setStatus($status);
            $this->commentManager->updateComment($comment);
            $redirectTo = "?action=dashboard";
        } else {
            $this->session->set(
                'error',
                'Aucun identifiant de commentaire envoyé'
            );
            $redirectTo = "?action=error";
        }
        $this->redirectTo($redirectTo);
    }

    public function addComment(bool $auth)
    {
        if ($auth) {
            $postId = intval($_POST['post']);
            $commentId = $_POST['comment'];
            if (!empty($postId) && $postId > 0) {
                $message = htmlspecialchars($_POST['message'], ENT_NOQUOTES);
                if (strlen($message) >= 10 && strlen($message) <= 255) {
                    if (!empty($commentId && $commentId > 0)) {
                        $comment = $this->commentManager->getComment($commentId);
                        if ($comment) {
                            $comment->setMessage($message);
                            $comment->setCreatedAt(date('Y-m-d H:i:s'));
                            $this->commentManager->updateComment($comment);
                            $this->session->set(
                                'success',
                                'Votre commentaire a été modifié avec succès.'
                            );
                            $redirectTo = "?action=blogpost&id=$postId";
                        } else {
                            $this->session->set(
                                'error',
                                'Identifiant invalide'
                            );
                            $redirectTo = "?action=error";
                        }
                    } else {
                        $user = $this->userManager->getUser($_SESSION['email']);
                        $post = $this->postManager->findPost($postId);
                        $comment = new Comment([
                            'message' => $message,
                            'user' => $user,
                            'post' => $post
                        ]);
                        $this->commentManager->addComment($comment);
                        $this->session->set(
                            'success',
                            'Merci pour votre commentaire, il sera soumis à approbation avant d\'être rendu public.'
                        );
                        $redirectTo = "?action=blogpost&id=$postId";
                    }
                } else {
                    $this->session->set(
                        'failure',
                        'Votre commentaire ne respecte pas les règles de validations'
                    );
                    $redirectTo = "?action=blogpost&id=$postId&message=$message";
                }
            } else {
                $this->session->set(
                    'error',
                    'Aucun identifiant d\'article envoyé'
                );
                $redirectTo = "?action=error";
            }
        } else {
            $this->session->set(
                'error',
                'Merci de vous authentifier pour poster un commentaire'
            );
            $redirectTo = "?action=error";
        }
        $this->redirectTo($redirectTo);
    }
}
