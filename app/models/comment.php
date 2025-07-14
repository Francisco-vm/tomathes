<?php

namespace App\Models;

use Config\Database;

class Comment
{
    public static function getByPostId(int $postId)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['post_id' => $postId]);

        return $stmt->fetchAll();
    }

    public static function create($postId, $parentId, $name, $content)
    {
        $pdo = Database::getInstance();

        $sql = "INSERT INTO comments (post_id, parent_id, name, content, created_at) VALUES (:post_id, :parent_id, :name, :content, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'post_id' => $postId,
            'parent_id' => $parentId,
            'name' => $name,
            'content' => $content
        ]);

        return $pdo->lastInsertId();
    }


}
