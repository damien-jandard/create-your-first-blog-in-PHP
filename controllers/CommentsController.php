<?php

namespace Controllers;

use Models\Entities\Comment;
use Models\Managers\CommentsManager;

class CommentsController
{
    public function defineStatusComment()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            if ($_GET['action'] === 'approvecomment') {
                $status = 1;
                $message = "commentapproved";
            }else {
                $status = 0;
                $message = "commentdenied";
            }
            $commentManager = new CommentsManager();
            $commentManager->updateCommentStatus($id, $status);
            $redirectTo = "?action=dashboard&message=$message";
        }else {
            $redirectTo = "?action=error&message=Aucun identifiant de commentaire envoyé";
        }
        header("Location: $redirectTo");
        exit;
    }
}
