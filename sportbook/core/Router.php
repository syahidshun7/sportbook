<?php
class Router {
    private array $routes = [];

    public function add(string $method, string $path, string $controller, string $action): void {
        $this->routes[] = compact('method', 'path', 'controller', 'action');
    }

    public function dispatch(string $url, string $method): void {
        $url = trim($url, '/');

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                $controllerFile = ROOT_PATH . '/app/controllers/' . $route['controller'] . '.php';
                require_once $controllerFile;
                $controller = new $route['controller']();
                call_user_func_array([$controller, $route['action']], $matches);
                return;
            }
        }

        http_response_code(404);
        require_once ROOT_PATH . '/app/views/layouts/404.php';
    }
}
