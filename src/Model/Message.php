<?php
namespace Model;

use Core\DB;

class Message
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function insertMessage(string $message, int $userId)
    {
        $pdo = $this->pdo->instance();

        $query = $pdo->prepare('insert into message(message_text, creation_date, user_id) values(?, now(), ?)');
        $query->execute([
            $message,
            $userId
        ]);
    }

    public function getMessages()
    {
        $pdo = $this->pdo->instance();
        $query = $pdo->prepare('
            select m.*, u.name from message m 
            join user u on m.user_id = u.id
            where m.creation_date > DATE_SUB(NOW(), INTERVAL 7 DAY)
            order by m.creation_date desc
        ');
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
