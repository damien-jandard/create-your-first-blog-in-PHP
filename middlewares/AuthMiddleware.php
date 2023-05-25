<?php

namespace Middlewares;

class AuthMiddleware implements IMiddleware
{
    public function checkAllowed()
    {
        return (!empty($_SESSION['auth']) && $_SESSION['auth']);
    }
}
