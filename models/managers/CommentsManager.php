<?php

namespace Models\Managers;

use PDO;

class CommentsManager extends Manager
{
    public function findAllPendingComments()
    {
        $query = 'SELECT comments.id, SUBSTR(comments.message, 1, 25) AS short_message, comments.message, users.email, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.status=0';
        $request = $this->pdo->prepare($query);
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}