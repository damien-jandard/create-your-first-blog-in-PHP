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
            if ($_GET['action'] === 'approvecomment') {
                $status = 1;
                $message = "commentapproved";
            }else {
                $status = 0;
                $message = "commentdenied";
            }
            $this->commentManager->updateCommentStatus($id, $status);
            $redirectTo = "?action=dashboard&message=$message";
        }else {
            $redirectTo = "?action=error&message=Aucun identifiant de commentaire envoyé";
        }
        header("Location: $redirectTo");
        exit;
    }
}
