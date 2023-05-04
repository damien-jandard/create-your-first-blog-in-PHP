<?php

namespace Controllers;

use Models\Entities\Post;
use Models\Managers\PostsManager;

class PostsController extends Controller
{
    public function newPost()
    {
        return $this->render('/post/new.html.twig');
    }

    public function addPost()
    {
        if (!empty($_POST['title']) && !empty($_POST['chapo']) && !empty($_POST['content'])) {
            $title = htmlspecialchars($_POST['title']);
            $chapo = htmlspecialchars($_POST['chapo']);
            $content = htmlspecialchars($_POST['content']);
            $post = new Post(['title' => $title, 'chapo' => $chapo, 'content' => $content]);
            $postManager = new PostsManager();
            $postManager->addPost($post);
            $redirectTo = "?action=dashboard&message=postadded";
        } else {
            $redirectTo = "?action=newpost&error=1&title=" . $_POST['title'] . "&chapo=" . $_POST['chapo'] . "&content=" . $_POST['content'];
        }
        header("Location: $redirectTo");
        exit;
    }
}
