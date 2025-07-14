<?php

namespace App\Models;

use Config\Database;

class Post
{
    public static function all()
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // Buscar posts filtrando por nombre de categoría (string)
    public static function getByCategorySlug(string $slug)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT p.* FROM posts p 
            INNER JOIN categories c ON p.category_id = c.id 
            WHERE c.slug = :slug 
            ORDER BY p.created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);

        return $stmt->fetchAll();
    }

    public static function getBySlug(string $slug)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM posts WHERE slug = :slug LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);

        return $stmt->fetch();
    }


    public static function getSlugById($postId)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT slug FROM posts WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $postId]);

        return $stmt->fetchColumn();
    }

}
