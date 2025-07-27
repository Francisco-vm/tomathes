<?php

namespace App\Controllers;

use App\Models\Author;

class LoginController extends BaseController
{
    public function showLoginForm()
    {
        require_once __DIR__ . '/../views/login.php';
    }

    public function login()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = "Todos los campos son obligatorios.";
            header("Location: /login");
            exit;
        }

        $author = Author::findByEmail($email);

        if ($author && password_verify($password, $author['password_hash'])) {
            $_SESSION['author_id'] = $author['id'];
            $_SESSION['author_name'] = $author['name'];

            header("Location: /admin/dashboard");
            exit;
        } else {
            $_SESSION['login_error'] = "Credenciales inválidas.";
            header("Location: /login");
            exit;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: /login");
        exit;
    }
}