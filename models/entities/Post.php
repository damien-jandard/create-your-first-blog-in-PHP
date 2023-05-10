<?php

namespace Models\Entities;

use DateTime;

class Post
{
    private int $id;
    private string $title;
    private string $chapo;
    private string $content;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private User $user;
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

    public function title()
    {
        return $this->title;
    }

    public function chapo()
    {
        return $this->chapo;
    }

    public function content()
    {
        return $this->content;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new DateTime($createdAt);
    }

    public function updatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->createdAt = new DateTime($updatedAt);
    }

    public function user()
    {
        return $this->user;
    }

    public function comments()
    {
        return $this->comments;
    }
}
