<?php

namespace App\Models;

use Config\Database;
use App\Helpers\Sanitizer;

class Post
{
    public $id;
    public $title;
    public $slug;
    public $content;
    public $category_id;
    public $author_id;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct()
    {

    }

    public function save()
    {
        $pdo = Database::getInstance();

        $this->slug = $this->generateSlug($this->title);

        $this->title = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');

        // Sanitizar el contenido con HTML Purifier
        $this->content = Sanitizer::cleanHTML($this->content);

        $sql = "INSERT INTO posts (title, slug, content, category_id, author_id, status, created_at, updated_at)
            VALUES (:title, :slug, :content, :category_id, :author_id, :status, :created_at, :updated_at)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'author_id' => $this->author_id,
            'status' => $this->status ?? 'draft',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at ?? date('Y-m-d H:i:s')
        ]);
    }

    public function update()
    {
        $pdo = Database::getInstance();

        // Sanitizar
        $this->title = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $this->content = Sanitizer::cleanHTML($this->content);

        $sql = "UPDATE posts SET title = :title, content = :content, category_id = :category_id, status = :status, updated_at = :updated_at WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'id' => $this->id
        ]);
    }

    private function generateSlug($string)
    {
        // Generar slug básico
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));

        // Verificar si existe en DB
        $pdo = Database::getInstance();
        $i = 1;
        $baseSlug = $slug;
        while ($pdo->prepare("SELECT COUNT(*) FROM posts WHERE slug = ?")->execute([$slug]) && $pdo->prepare("SELECT COUNT(*) FROM posts WHERE slug = ?")->fetchColumn() > 0) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }

    public static function all()
    {
        $pdo = Database::getInstance();

        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM posts p
            INNER JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function getByCategorySlug(string $slug)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM posts p 
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

    public static function getById($id)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM posts WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch();

        if ($data) {
            $post = new self();
            $post->id = $data['id'];
            $post->title = $data['title'];
            $post->slug = $data['slug'];
            $post->content = $data['content'];
            $post->category_id = $data['category_id'];
            $post->author_id = $data['author_id'];
            $post->status = $data['status'];
            $post->created_at = $data['created_at'];
            $post->updated_at = $data['updated_at'];
            return $post;
        }

        return null;
    }
}
