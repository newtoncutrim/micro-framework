<?php

namespace App\Router;

use App\Http\Request;

class Router
{
    private $routes = [];

    public function addRoute(string $method, string $path, $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri)
    {
        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['path']);
            if ($route['method'] === strtoupper($method) && preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove o primeiro elemento (URI completo)

                // Instanciar o objeto Request
                $request = new Request();

                // Resolver o handler
                return $this->resolveHandler($route['handler'], array_merge([$request], $matches));
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/\{([\w]+)\}/', '([\w-]+)', $path);
        return "#^" . $pattern . "$#";
    }

    private function resolveHandler($handler, array $params = [])
    {
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }

        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$controller, $method] = explode('@', $handler);

            $controllerClass = "App\\Controller\\$controller";

            if (class_exists($controllerClass)) {
                // Resolver dependências do construtor
                $controllerInstance = $this->resolveControllerDependencies($controllerClass);

                if (method_exists($controllerInstance, $method)) {
                    return call_user_func_array([$controllerInstance, $method], $params);
                }

                throw new \Exception("Método $method não encontrado no controlador $controllerClass.");
            }

            throw new \Exception("Controlador $controllerClass não encontrado.");
        }

        throw new \Exception("Handler inválido.");
    }

    private function resolveControllerDependencies(string $controllerClass)
    {
        $reflection = new \ReflectionClass($controllerClass);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $controllerClass(); // Sem dependências
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                $className = $type->getName();

                if ($className === 'App\\ORM\\ORM') {
                    // Criar instância de ORM com a tabela apropriada
                    $dependencies[] = new \App\ORM\ORM('users', $this->getConnection());
                } else {
                    throw new \Exception("Não foi possível resolver a dependência: $className");
                }
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    private function getConnection()
    {
        // Aqui você retorna sua conexão com o banco de dados
        return new \App\Config\DB\Connection();
    }

}
