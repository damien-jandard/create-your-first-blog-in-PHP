<?php

namespace Models\Managers;

use PDO;
use Models\Entities\User;
use Models\Entities\Comment;
use Models\Entities\Post;

class CommentsManager extends Manager
{
    public function findAllPendingComments()
    {
        $query = 'SELECT comments.id as comment_id, comments.message, users.id as user_id, users.email, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.status=2';
        $request = $this->pdo->prepare($query);
        $request->execute();
        $comments = [];
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $data) {
            $user = new User($data);
            $comment = new Comment(array_merge($data, ['user' => $user]));
            $comments[] = $comment;
        }
        return $comments;
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

    public function findAllCommentsOfBlogPost(int $id)
    {
        $query = 'SELECT comments.id as comment_id, comments.message, users.id as user_id, users.email, comments.created_at FROM comments LEFT JOIN users ON comments.user_id=users.id LEFT JOIN posts ON comments.post_id=posts.id WHERE comments.status=1 AND post_id=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$id]);
        $comments = [];
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $data) {
            $user = new User($data);
            $post = new Post($data);
            $comment = new Comment(array_merge($data, ['user' => $user], ['post' => $post]));
            $comments[] = $comment;
        }
        return $comments;
    }

    public function addComment(Comment $comment)
    {
        $query = 'INSERT INTO comments (user_id, post_id, message, created_at) VALUES (?, ?, ?, NOW())';
        $request = $this->pdo->prepare($query);
        $request->execute([$comment->user()->id(), $comment->post()->id(), $comment->message()]);
    }
}