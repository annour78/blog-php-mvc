<?php
class Router {
    private $routes = [];

    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($method, $url) {
        $url = '/' . trim($url, '/');
        if ($url === '//') $url = '/';

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-z_]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                require_once __DIR__ . '/../app/controllers/' . $route['controller'] . '.php';
                $controller = new $route['controller']();
                call_user_func_array([$controller, $route['action']], $matches);
                return;
            }
        }
        http_response_code(404);
        echo "<h1>404 - Page not found</h1>";
    }
}