<?php

namespace Models\Managers;

use PDO;

class Manager
{
    protected \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=blog;charset=utf8', 'root', '');
    }

    public function disableForeignKey()
    {
        $query = 'SET FOREIGN_KEY_CHECKS=0';
        $request = $this->pdo->prepare($query);
        $request->execute();
    }

    public function enableForeignKey()
    {
        $query = 'SET FOREIGN_KEY_CHECKS=1';
        $request = $this->pdo->prepare($query);
        $request->execute();
    }
}
