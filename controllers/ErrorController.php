<?php

namespace Controllers;

class ErrorController extends Controller
{
    public function error()
    {
        return $this->render('error/error.html.twig');
    }
}