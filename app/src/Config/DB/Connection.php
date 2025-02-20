<?php

namespace App\Config\DB;

use PDO;
use PDOException;

class Connection
{
    private ?PDO $pdo = null;

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        $host = 'database';
        $dbname = 'db';
        $user = 'root';
        $password = '1234';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }

    public function getPDO(): PDO
    {
        if ($this->pdo === null) {
            throw new \RuntimeException("A conexão com o banco de dados não foi inicializada.");
        }

        return $this->pdo;
    }
}
