<?php

namespace Controllers;

use Models\Entities\Comment;
use Models\Entities\User;
use Models\Managers\CommentsManager;
use Models\Managers\PostsManager;
use Models\Managers\UsersManager;

class CommentsController extends Controller
{
    private $commentManager;
    private $userManager;
    private $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentsManager();
        $this->userManager = new UsersManager();
        $this->postManager = new PostsManager();
    }

    public function defineStatusComment()
    {
        if (!empty($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $comment = $this->commentManager->getComment($id);
            if ($_GET['action'] === 'approvecomment') {
                $status = true;
                $message = "commentapproved";
            }else {
                $status = false;
                $message = "commentdenied";
            }
            $comment->setStatus($status);
            $this->commentManager->updateComment($comment);
            $redirectTo = "?action=dashboard&message=$message";
        }else {
            $redirectTo = "?action=error&message=Aucun identifiant de commentaire envoyé";
        }
        header("Location: $redirectTo");
        exit;
    }

    public function addComment(bool $auth)
    {
        if ($auth) {
            $postId = $_POST['post'];
            $commentId = $_POST['comment'];
            if (!empty($postId) && $postId > 0) {
                $message = htmlspecialchars($_POST['message'], ENT_NOQUOTES);
                if (strlen($message) >= 10 && strlen($message) <= 255) {
                    if (!empty($commentId && $commentId > 0)) {
                        $comment = $this->commentManager->getComment($commentId);
                        $comment->setMessage($message);
                        $comment->setCreatedAt(date('Y-m-d H:i:s'));
                        $this->commentManager->updateComment($comment);
                        $message = "Votre commentaire a été modifié avec succès.";
                        $redirectTo = "?action=blogpost&id=$postId&message=$message";
                    }else {
                        $user = $this->userManager->getUser($_SESSION['email']);
                        $post = $this->postManager->findPost($postId);
                        $comment = new Comment(['message' => $message, 'user' => $user, 'post' => $post]);
                        $this->commentManager->addComment($comment);
                        $message = "Merci pour votre commentaire, celui-ci est soumis à approbation avant d'être rendu public.";
                        $redirectTo = "?action=blogpost&id=$postId&message=$message";
                    }
                }else {
                    $redirectTo = "?action=error&message=Votre commentaire ne respecte pas les règles de validations";
                }
            }else {
                $redirectTo = "?action=error&message=Aucun identifiant d'article envoyé";
            }
        }else {
            $redirectTo = "?action=error&message=Merci de vous authentifier pour poster un commentaire";
        }
        header("Location: $redirectTo");
        exit;
    }
}
