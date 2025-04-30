<?php

namespace Router;

use Service\Response;


class Router
{

    protected $routes = [];

    private function addRoute($method, $uri, $controllerPath)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controllerPath' => $controllerPath
        ];

        return $this;
    }

    public function get($uri, $controller)
    {
        $this->addRoute('GET', $uri, $controller);
    }


    public function post($uri, $controller)
    {
        $this->addRoute('POST', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        $this->addRoute('PUT', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->addRoute('DELETE', $uri, $controller);
    }

    public function any($uri, $controller)
    {
        $this->addRoute('ANY', $uri, $controller);
    }

    public function getRoutes()
    {
        return $this->routes;
    }


    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            // Convert URI pattern to regex
            $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '([a-zA-Z0-9-_]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches) && $route['method'] === $method) {
                array_shift($matches); // remove full match

                $controllerPath = base_path('src/Http/controller/' . $route['controllerPath']);
                if (file_exists($controllerPath)) {
                    $controller = require_once $controllerPath;

                    // If controller is a class, instantiate and call
                    if (is_object($controller) && method_exists($controller, 'handle')) {
                        return call_user_func_array([$controller, 'handle'], $matches);
                    }

                    // Otherwise, assume it's a function
                    if (is_callable($controller)) {
                        return call_user_func_array($controller, $matches);
                    }
                }

                $this->abort("Controller not found", 500);
                return;
            }
        }

        $this->abort();
    }

    protected function redirect($uri, $method)
    {
        return;
    }

    protected function abort($message = 'Page Not Found', $statusCode = 404)
    {
        Response::json(['message' => $message], $statusCode);
    }
}