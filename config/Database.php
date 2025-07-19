<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private static ?self $instance = null;
    private PDO $pdo;
    private string $appEnv;

    private function __construct()
    {
        $this->appEnv = $_ENV['APP_ENV'] ?? 'production';

        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $db = $_ENV['DB_DATABASE'] ?? 'test';
        $user = $_ENV['DB_USERNAME'] ?? 'root';
        $pass = $_ENV['DB_PASSWORD'] ?? '';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            http_response_code(500);

            if ($this->appEnv === 'local') {
                echo "Database connection failed: " . htmlspecialchars($e->getMessage());
            } else {
                echo "Database connection failed.";
            }

            exit;
        }
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }

}


/*para llamarlo lo hago así: 

use Config\Database; Importo la clase

$pdo = Database::getInstance(); llamo a la función

$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();

*/