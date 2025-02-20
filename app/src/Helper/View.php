<?php

namespace App\Helper;

class View
{
    /**
     * Renderiza uma view.
     *
     * @param string $view O caminho da view (relativo ao diretório de views).
     * @param array $data Dados a serem passados para a view.
     * @return void
     */
    public static function render(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View '{$view}' não encontrada.");
        }

        // Extrai as variáveis do array $data para a view.
        extract($data);

        // Inclui o arquivo da view.
        require $viewPath;
    }
}