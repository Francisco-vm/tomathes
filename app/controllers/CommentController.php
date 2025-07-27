<?php

namespace App\Controllers;

use App\Models\Comment;

class CommentController extends BaseController
{
    public function create()
    {
        header('Content-Type: application/json; charset=utf-8');

        $postId = $_POST['post_id'] ?? null;
        $parentId = $_POST['parent_id'] ?: null;
        $name = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars(trim($_POST['content'] ?? ''), ENT_QUOTES, 'UTF-8');

        if ($postId && $name && $content) {
            $commentId = Comment::create($postId, $parentId, $name, $content);

            if ($commentId) {
                echo json_encode([
                    'success' => true,
                    'comment' => [
                        'id' => $commentId,
                        'name' => htmlspecialchars($name),
                        'content' => nl2br(htmlspecialchars($content)),
                        'parent_id' => $parentId
                    ]
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al guardar el comentario.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos para crear el comentario.'
            ]);
        }

        exit;
    }
}
