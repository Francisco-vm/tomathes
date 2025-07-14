<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\CommentController;

return [
    'GET' => [
        '/' => [HomeController::class, 'index'],

        // Listado general de posts
        '/posts' => [PostController::class, 'index'],

        // Vista de un post específico por id
        '/posts/view/{id}' => [PostController::class, 'view'],

        // Filtrar posts por categoría (usando name de category)
        '/posts/{slug}' => [PostController::class, 'category'],

        // Vista de un post específico por slug
        '/post/{slug}' => [PostController::class, 'view'],
    ],

    'POST' => [
        '/posts/create' => [PostController::class, 'create'],
        '/posts/edit/{id}' => [PostController::class, 'edit'],
        '/posts/delete/{id}' => [PostController::class, 'delete'],
        '/comments/create' => [CommentController::class, 'create'],
    ],
];
