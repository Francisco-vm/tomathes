<?php

namespace App\Core;

class Router
{
    private array $routes;

    public function __construct()
    {
        // Cargar las rutas definidas en app/routes/routes.php
        $this->routes = require __DIR__ . '/../routes/routes.php';
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Normalizar URI eliminando '/' final excepto si es raíz
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        if (!isset($this->routes[$method])) {
            http_response_code(405);
            echo "405 - Método no permitido.";
            return;
        }

        foreach ($this->routes[$method] as $route => [$controllerClass, $controllerMethod]) {
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<\1>[^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                if (class_exists($controllerClass) && method_exists($controllerClass, $controllerMethod)) {
                    $controller = new $controllerClass();

                    // Extraer solo los parámetros nombrados
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    // Decodificar parámetros para que no tengan %C3%B3, %20, etc.
                    foreach ($params as &$param) {
                        $param = urldecode($param);
                    }

                    call_user_func_array([$controller, $controllerMethod], $params);

                    return;
                } else {
                    http_response_code(500);
                    echo "Error: método o clase no encontrados.";
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 - Página no encontrada.";
    }
}
