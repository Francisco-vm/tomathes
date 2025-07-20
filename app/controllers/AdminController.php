<?php

namespace App\Controllers;

use App\Models\Post;

class AdminController
{
    public function dashboard()
    {
        require_once __DIR__ . '/../middlewares/auth.php';

        $posts = Post::All();

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}
