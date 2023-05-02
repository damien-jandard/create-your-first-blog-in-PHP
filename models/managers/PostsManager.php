<?php

namespace Models\Managers;

use Models\Entities\Post;

class PostsManager extends Manager
{
    public function addPost(Post $post)
    {
        $query = 'INSERT INTO posts (user_id, title, chapo, content, created_at) VALUES (1, ?, ?, ?, NOW())';
        $request = $this->pdo->prepare($query);
        $request->execute([$post->title(), $post->chapo(), $post->content()]);
    }
}
