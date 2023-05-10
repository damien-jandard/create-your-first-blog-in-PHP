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
            $correctKey = snakeToCamel($key);
            $method = 'set' . ucfirst($correctKey);
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                $this->$correctKey = $value;
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

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new DateTime($createdAt);
    }

    public function setUserId($id)
    {
        $this->id = $id;
    }

    public function checkPassword(string $password): bool
    {
        return (!empty($this->password()) && password_verify($password, $this->password()));
    }
}
