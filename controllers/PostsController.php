<?php

namespace Controllers;

use App\PHPSession;
use Models\Entities\Post;
use Models\Entities\User;
use Models\Managers\CommentsManager;
use Models\Managers\PostsManager;

class PostsController extends Controller
{
    private $postManager;
    private $commmentsManager;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->postManager = new PostsManager();
        $this->commmentsManager = new CommentsManager;
        $this->session = new PHPSession();
    }

    public function newPost()
    {
        $failure = $this->session->get('failure');
        return $this->render('/posts/new.html.twig', compact('failure'));
    }

    public function addPost()
    {
        if (!empty($_POST['title']) && !empty($_POST['chapo']) && !empty($_POST['content'])) {
            $title = $_POST['title'];
            $chapo = $_POST['chapo'];
            $content = $_POST['content'];
            $user = new User(['id' => $_SESSION['id']]);
            $post = new Post(['title' => $title, 'chapo' => $chapo, 'content' => $content, 'user' => $user]);
            $this->postManager->addPost($post);
            $this->session->set('success', 'L\'article a été ajouté avec succès.');
            $redirectTo = "?action=dashboard";
        } else {
            $this->session->set('failure', 'Merci de remplir tous les champs pour créer un nouvel article.');
            $redirectTo = "?action=newpost&title=" . $_POST['title'] . "&chapo=" . $_POST['chapo'] . "&content=" . $_POST['content'];
        }
        header("Location: $redirectTo");
        exit;
    }

    public function editPost()
    {
        if (!empty($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $post = $this->postManager->findPost($id);
            if ($post) {
                $failure = $this->session->get('failure');
                return $this->render('/posts/edit.html.twig', compact('post', 'failure'));
            } else {
                $this->session->set('failure', 'L\'article demandé n\'existe pas.');
                $redirectTo = "?action=dashboard";
                header("Location: $redirectTo");
                exit;
            }
        } else {
            $this->session->set('failure', 'Aucun identifiant d\'article envoyé.');
            $redirectTo = "?action=dashboard";
            header("Location: $redirectTo");
            exit;
        }
    }

    public function savePost()
    {
        if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['chapo']) && !empty($_POST['content'])) {
            $id = intval($_POST['id']);
            $title = $_POST['title'];
            $chapo = $_POST['chapo'];
            $content = $_POST['content'];
            $user = new User(['id' => $_SESSION['id']]);
            $post = new Post(['id' => $id, 'title' => $title, 'chapo' => $chapo, 'content' => $content, 'user' => $user]);
            $this->postManager->savePost($post);
            $this->session->set('success', 'L\'article a été mis à jour.');
            $redirectTo = "?action=dashboard";
        } else {
            $this->session->set('failure', 'Merci de remplir tous les champs pour mettre à jour l\'article.');
            $redirectTo = "?action=editpost&id=" . $_POST['id'];
        }
        header("Location: $redirectTo");
        exit;
    }

    public function deletePost()
    {
        if (!empty($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $this->postManager->deletePost($id);
            $this->session->set('success', 'L\'article a été supprimé avec succès.');
            $redirectTo = "?action=dashboard";
        } else {
            $this->session->set('failure', 'Aucun identifiant d\'article envoyé.');
            $redirectTo = "?action=dashboard";
        }
        header("Location: $redirectTo");
        exit;
    }

    public function blog()
    {
        $posts = $this->postManager->findAllPost('ORDER BY posts.updated_at DESC, posts.created_at DESC');
        return $this->render('/posts/blog.html.twig', compact('posts'));
    }

    public function blogpost(bool $auth)
    {
        if (!empty($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $post = $this->postManager->findPost($id);
            if ($post) {
                $comments = $this->commmentsManager->findAllCommentsOfBlogPost($id);
                $success = $this->session->get('success');
                $failure = $this->session->get('failure');
                return $this->render('/posts/blogpost.html.twig', compact('post', 'comments', 'auth', 'success', 'failure'));
            } else {
                $this->session->set('error', 'Identifiant d\'article invalide');
                $redirectTo = "?action=error";
            }
        } else {
            $this->session->set('error', 'Aucun identifiant d\'article envoyé');
            $redirectTo = "?action=error";
        }
        header("Location: $redirectTo");
        exit;
    }
}
