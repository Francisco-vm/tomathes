<?php

namespace App\Controllers;

use App\Models\Post;

class AdminController extends BaseController
{
    public function dashboard()
    {
        require_once __DIR__ . '/../middlewares/auth.php';

        $posts = Post::all();

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}