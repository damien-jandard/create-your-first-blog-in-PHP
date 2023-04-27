<?php

namespace Models\Managers;

use PDO;
use Models\Entities\User;

class UsersManager extends Manager
{
    public function register(User $user)
    {
        $query = 'INSERT INTO users (email, password, token, created_at) VALUES (?, ?, ?, NOW())';
        $request = $this->pdo->prepare($query);
        $request->execute([$user->email(), $user->password(), $user->token()]);
    }

    public function registered(User $user)
    {
        $query = 'UPDATE users SET status =1 WHERE email=? AND token=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$user->email(), $user->token()]);
    }

    public function checkUser(string $email)
    {
        $query = 'SELECT id FROM users WHERE email=?';
        $request = $this->pdo->prepare($query);
        $request->execute([$email]);
        $result = $request->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
