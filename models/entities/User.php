<?php

namespace Models\Entities;

use DateTime;

class User
{
    private int $id;
    private string $email;
    private string $password;
    private bool $isAdmin;
    private bool $status;
    private string $token;
    private DateTime $createdAt;
    private array $posts = [];
    private array $comments = [];

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (method_exists($this, 'set' . ucfirst($key))) {
                $method = 'set' . ucfirst($key);
                $this->$method($value);
            } else {
                $this->$key = $value;
            }
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }

    public function password()
    {
        return $this->password;
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function status()
    {
        return $this->status;
    }

    public function token()
    {
        return $this->token;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public function posts()
    {
        return $this->posts;
    }

    public function comments()
    {
        return $this->comments;
    }
}
