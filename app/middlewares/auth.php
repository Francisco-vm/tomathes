<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['author_id'])) {
    header("Location: /login");
    exit;
}