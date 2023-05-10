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

    public function message()
    {
        return $this->message;
    }

    public function status()
    {
        return $this->status;
    }

    public function setStatus(bool $status)
    {
        $this->status = $status;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new DateTime($createdAt);
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
