<?php

namespace Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\String\StringExtension;

abstract class Controller
{
    private $loader;
    protected $twig = null;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('../views');
        $this->twig = new Environment($this->loader, [
            'cache' => false,
        ]);
        $this->twig->addExtension(new StringExtension());
    }

    protected function render(string $twigFile, array $parameters = null)
    {
        try {
            $this->twig->addGlobal('_session', $_SESSION);
            $this->twig->addGlobal('_get', $_GET);
            $this->twig->addGlobal('_post', $_POST);
            if ($parameters != null) {
                echo $this->twig->render($twigFile, $parameters);
            } else {
                echo $this->twig->render($twigFile);
            }
        } catch (\Exception $e) {
            var_dump($e);
            return false;
        }
        return true;
    }
}
