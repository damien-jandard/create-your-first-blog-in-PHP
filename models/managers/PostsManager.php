<?php

namespace Models\Managers;

use PDO;
use Models\Entities\Post;

class PostsManager extends Manager
{
    public function addPost(Post $post)
    {
        $query = 'INSERT INTO posts (user_id, title, chapo, content, created_at) VALUES (?, ?, ?, ?, NOW())';
        $request = $this->pdo->prepare($query);
        $request->execute([$post->user()->id(), $post->title(), $post->chapo(), $post->content()]);
    }

    public function findAllPost()
    {
        $query = 'SELECT posts.id, posts.title, users.email, posts.created_at FROM posts LEFT JOIN users ON posts.user_id = users.id';
        $request = $this->pdo->prepare($query);
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deletePost(int $id)
    {
        $this->disableForeignKey();
        $query = 'DELETE FROM posts WHERE id=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$id]);
        $this->enableForeignKey();
    }
}
