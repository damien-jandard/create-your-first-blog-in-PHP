<?php

namespace Middlewares;

class AuthMiddleware implements iMiddleware
{
    public function checkAllowed()
    {
        return (!empty($_SESSION['auth']) && $_SESSION['auth']);
    }
}
