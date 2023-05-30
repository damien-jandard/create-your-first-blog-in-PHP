<?php

namespace App;

class PHPSession
{
    public function get(string $key, string $default = null): ?string
    {
        if (array_key_exists($key, $_SESSION)) {
            $value = $_SESSION[$key];
            $this->delete($key);
            return $value;
        }
        return $default;
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
