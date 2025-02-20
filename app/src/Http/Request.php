<?php

namespace App\Http;

class Request
{
    private $method;
    private $uri;
    private $body;
    private $queryParams;
    private $headers;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->body = $this->getBody();
        $this->queryParams = $_GET;
        $this->headers = getallheaders();
    }

    // Retorna o método da requisição (GET, POST, etc.)
    public function getMethod(): string
    {
        return $this->method;
    }

    // Retorna a URI da requisição
    public function getUri(): string
    {
        return $this->uri;
    }

    // Retorna os dados do corpo da requisição
    public function getBody(): array
    {
        if ($this->method === 'POST' || $this->method === 'PUT' || $this->method === 'PATCH') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

            if (strpos($contentType, 'application/json') !== false) {
                $input = file_get_contents('php://input');
                return json_decode($input, true) ?? [];
            }

            return $_POST;
        }

        return [];
    }

    // Retorna os parâmetros da query string
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    // Retorna os cabeçalhos da requisição
    public function getHeaders(): array
    {
        return $this->headers;
    }

    // Retorna um dado específico do corpo
    public function get(string $key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }
}
