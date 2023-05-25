<?php

namespace Controllers;

use App\PHPSession;

class ErrorController extends Controller
{
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = new PHPSession();
    }

    public function error()
    {
        $error = $this->session->get('error');
        return $this->render('error/error.html.twig', compact('error'));
    }
}