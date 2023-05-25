<?php

namespace Middlewares;

use App\PHPSession;

class AdminMiddleware implements iMiddleware
{
    private $session;

    public function __construct()
    {
        $this->session = new PHPSession();
    }

    public function checkAllowed()
    {
        if (empty($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $this->session->set('error', 'Nous sommes désolés, mais vous n\'avez pas accès à cette page ou cette ressource.');
            $redirectTo = "?action=error";
            header("Location: $redirectTo");
            exit;
        }
    }
}
