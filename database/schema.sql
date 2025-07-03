-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS tomathes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tomathes;

-- Tabla de perfil del administrador
CREATE TABLE author(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    bio TEXT
);

-- Tabla de credenciales del administrador
CREATE TABLE author_credentials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    FOREIGN KEY (author_id) REFERENCES author(id) ON DELETE CASCADE
);

-- Tabla de categorías
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Tabla de publicaciones con relación a autor
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    category_id INT NOT NULL,
    author_id INT NOT NULL,
    status ENUM('draft', 'published', 'deleted') DEFAULT 'draft',
    created_at DATETIME,
    updated_at DATETIME,
    published_at DATETIME DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (author_id) REFERENCES author(id)
);

-- Tabla de comentarios
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    parent_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    content TEXT NOT NULL,
    status ENUM('visible', 'hidden', 'deleted', 'pending') DEFAULT 'visible',
    created_at DATETIME,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE
);

CREATE TABLE comment_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comment_id INT NOT NULL,
    reason TEXT,
    created_at DATETIME,
    FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE
);