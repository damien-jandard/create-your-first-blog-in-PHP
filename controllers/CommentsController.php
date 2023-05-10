<?php

namespace Controllers;

use Models\Managers\CommentsManager;

class CommentsController extends Controller
{
    private $commentManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentsManager();
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
}
