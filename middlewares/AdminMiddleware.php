<?php

namespace Middlewares;

class AdminMiddleware implements iMiddleware
{
    public function checkAllowed()
    {
        if (empty($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $redirectTo = "?action=error&message=403";
            header("Location: $redirectTo");
            exit;
        }
    }
}
