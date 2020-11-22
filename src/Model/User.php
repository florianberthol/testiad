<?php
namespace Model;

use Core\DB;

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function identifyUser(string $username, string $password): ?array
    {
        $userData = null;
        $pdo = $this->pdo->instance();
        $user = $this->isUserExist($username);

        if (empty($user)) {
            $query = $pdo->prepare('insert into user(name, password, last_connection) values(?, ?, now())');
            $query->execute([
                $username,
                password_hash($password, PASSWORD_DEFAULT)
            ]);

            $userData = [
                'name' => $username,
                'id' => $pdo->lastInsertId(),
            ];
        } else {
            if (password_verify($password, $user['password'])) {
                $userData = [
                    'name' => $user['name'],
                    'id' => $user['id']
                ];

                $query = $pdo->prepare('update user set last_connection = now() where id = ?');
                $query->execute([
                    $user['id']
                ]);
            }
        }

        return $userData;
    }

    public function getConnectedUser()
    {
        $pdo = $this->pdo->instance();
        $query = $pdo->prepare('
            select name from user
            where last_connection > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ');
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function isUserExist(string $userName)
    {
        $pdo = $this->pdo->instance();
        $query = $pdo->prepare('select * from user where name = ?');
        $query->execute([$userName]);
        $user = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $user[0];
    }
}