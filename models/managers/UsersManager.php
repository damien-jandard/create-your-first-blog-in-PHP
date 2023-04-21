<?php

namespace Models\Managers;

use Models\Entities\User;

class UsersManager extends Manager
{
    public function register(User $user)
    {
        $query = 'INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())';
        $request = $this->pdo->prepare($query);
        $request->execute([$user->email(), $user->password()]);
    }
}
