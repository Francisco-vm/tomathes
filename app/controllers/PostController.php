<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class PostController
{
    public function index()
    {
        $posts = Post::all();
        $categories = Category::all();
        require __DIR__ . '/../views/posts.php';
    }

    public function category(string $slug)
    {
        $posts = Post::getByCategorySlug($slug);
        $categories = Category::all();
        require __DIR__ . '/../views/posts.php';
    }

    public function view(string $slug)
    {
        $post = Post::getBySlug($slug);

        if (!$post) {
            http_response_code(404);
            echo "404 - Publicación no encontrada.";
            return;
        }

        $comments = Comment::getByPostId($post['id']);

        require __DIR__ . '/../views/post_view.php';
    }

}
