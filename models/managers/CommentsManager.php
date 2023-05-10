<?php

namespace Models\Managers;

use Models\Entities\Comment;
use PDO;

class CommentsManager extends Manager
{
    public function findAllPendingComments()
    {
        $query = 'SELECT comments.id, SUBSTR(comments.message, 1, 25) AS short_message, comments.message, users.email, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.status=2';
        $request = $this->pdo->prepare($query);
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getComment(int $id): Comment
    {
        $query = 'SELECT * FROM comments WHERE id=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$id]);
        return new Comment($request->fetch(PDO::FETCH_ASSOC));
    }

    public function updateComment(Comment $comment): void
    {
        $query = 'UPDATE comments SET status=?, message=? WHERE id=?';
        $request = $this->pdo->prepare($query);
        $request->execute([(int)$comment->status(), $comment->message(), $comment->id()]);
    }
}