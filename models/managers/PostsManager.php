<?php

namespace Models\Managers;

use PDO;
use Models\Entities\Post;
use Models\Entities\User;

class PostsManager extends Manager
{
    public function addPost(Post $post)
    {
        $query = 'INSERT INTO posts (user_id, title, chapo, content, created_at) VALUES (?, ?, ?, ?, NOW())';
        $request = $this->pdo->prepare($query);
        $request->execute([$post->user()->id(), $post->title(), $post->chapo(), $post->content()]);
    }

    public function savePost(Post $post)
    {
        $query = 'UPDATE posts SET user_id=?, title=?, chapo=?, content=?, updated_at=NOW() WHERE id=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$post->user()->id(), $post->title(), $post->chapo(), $post->content(), $post->id()]);
    }

    public function findPost(int $id)
    {
        $query = 'SELECT posts.id as post_id, posts.title, posts.chapo, posts.content, posts.created_at, users.id as user_id, users.email FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.id=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$id]);
        $result = $request->fetch(PDO::FETCH_ASSOC);
        $user = new User($result);
        $post = new Post(array_merge($result, ['user' => $user]));
        return $post;
    }

    public function findAllPost()
    {
        $query = 'SELECT posts.id as post_id, posts.title, posts.content, users.id as user_id, users.email, posts.created_at FROM posts LEFT JOIN users ON posts.user_id = users.id';
        $request = $this->pdo->prepare($query);
        $request->execute();
        $posts = [];
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $data) {
            $user = new User($data);
            $post = new Post(array_merge($data, ['user' => $user]));
            $posts[] = $post;
        }
        return $posts;
    }

    public function recentPost()
    {
        $query = 'SELECT posts.id as post_id, posts.title, posts.content, users.id as user_id, users.email, posts.created_at, posts.updated_at FROM posts LEFT JOIN users ON posts.user_id = users.id ORDER BY posts.updated_at DESC, posts.created_at DESC LIMIT 3';
        $request = $this->pdo->prepare($query);
        $request->execute();
        $posts = [];
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $data) {
            $user = new User($data);
            $post = new Post(array_merge($data, ['user' => $user]));
            $posts[] = $post;
        }
        return $posts;
    }

    public function deletePost(int $id)
    {
        $query = 'DELETE FROM posts WHERE id=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$id]);
    }
}
