<?php

namespace App\Models;

use Config\Database;
use PDO;

class Author
{
    public static function findByEmail($email)
    {
        $pdo = Database::getInstance();

        $sql = "
            SELECT a.id, a.name, a.email, a.bio, ac.password_hash
            FROM author a
            JOIN author_credentials ac ON a.id = ac.author_id
            WHERE a.email = :email
            LIMIT 1
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        return $author ?: null;
    }
}
