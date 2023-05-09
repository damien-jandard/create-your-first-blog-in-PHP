<?php

namespace Models\Entities;

use DateTime;

class Comment
{
    private int $id;
    private string $message;
    private bool $status;
    private DateTime $createdAt;
    private User $user;
    private Post $post;

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

    public function message()
    {
        return $this->message;
    }

    public function status()
    {
        return intval($this->status);
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public function user()
    {
        return $this->user;
    }

    public function post()
    {
        return $this->post;
    }
}
