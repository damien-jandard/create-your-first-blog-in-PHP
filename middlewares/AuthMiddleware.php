<?php

namespace Middlewares;

class AuthMiddleware implements MiddlewareInterface
{
    public function checkAllowed()
    {
        return (!empty($_SESSION['auth']) && $_SESSION['auth']);
    }
}
