<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use function App\Helpers\parseMarkdown;


class PostController extends BaseController
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
    
    $post['content_html'] = parseMarkdown($post['content']);

    $comments = Comment::getByPostId($post['id']);

    require __DIR__ . '/../views/post_view.php';
}



    public function createForm()
    {
        require_once __DIR__ . '/../middlewares/auth.php';

        $categories = Category::all();

        require_once __DIR__ . '/../views/admin/posts/create.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../middlewares/auth.php';

        if (empty($_POST['title']) || empty($_POST['content'])) {
            $_SESSION['error'] = 'Título y contenido son obligatorios.';
            header('Location: /posts/create');
            exit;
        }

        // Crear nuevo post
        $post = new Post();
        $post->title = $_POST['title'];
        $post->content = $_POST['content'];
        $post->category_id = $_POST['category_id'];
        $post->author_id = $_SESSION['author_id'];
        $post->created_at = date('Y-m-d H:i:s');

        if ($post->save()) {
            $_SESSION['success'] = 'Post creado correctamente.';
            header('Location: /admin/dashboard');
            exit;
        } else {
            $_SESSION['error'] = 'Error al crear el post.';
            header('Location: /posts/create');
            exit;
        }
    }

    public function editForm($id)
    {
        require_once __DIR__ . '/../middlewares/auth.php';

        $post = Post::getById($id);
        if (!$post) {
            $_SESSION['error'] = 'Publicación no encontrada.';
            header('Location: /admin/dashboard');
            exit;
        }

        $categories = Category::all();

        require_once __DIR__ . '/../views/admin/posts/edit.php';
    }

    public function edit($id)
    {
        require_once __DIR__ . '/../middlewares/auth.php';

        $post = Post::getById($id);

        if (!$post) {
            $_SESSION['error'] = 'Post no encontrado.';
            header('Location: /admin/dashboard');
            exit;
        }

        if (empty($_POST['title']) || empty($_POST['content'])) {
            $_SESSION['error'] = 'Título y contenido son obligatorios.';
            header('Location: /posts/edit/' . $id);
            exit;
        }

        $post->title = $_POST['title'];
        $post->content = $_POST['content'];
        $post->category_id = $_POST['category_id'];
        $post->updated_at = date('Y-m-d H:i:s');

        // Determinar acción
        switch ($_POST['action']) {
            case 'draft':
                $post->status = 'draft';
                break;
            case 'publish':
                $post->status = 'published';
                break;
            case 'delete':
                $post->status = 'deleted';
                break;
            default:
                $_SESSION['error'] = 'Acción no válida.';
                header('Location: /posts/edit/' . $id);
                exit;
        }

        if ($post->update()) {
            $_SESSION['success'] = 'Post actualizado correctamente.';
            header('Location: /admin/dashboard');
            exit;
        } else {
            $_SESSION['error'] = 'Error al actualizar el post.';
            header('Location: /posts/edit/' . $id);
            exit;
        }
    }
}