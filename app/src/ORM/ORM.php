<?php

namespace App\ORM;

use App\Config\DB\Connection;

class ORM
{
    public function __construct(private string $table, private Connection $connection)
    { }

    public function all()
    {
        $result = $this->connection->getPDO()->query("SELECT * FROM {$this->table}");
        return $result->fetchAll();

    }

    public function find($id)
    {
        $result = $this->connection->getPDO()->query("SELECT * FROM {$this->table} WHERE id = $id");
        return $result->fetch();
    }

    public function create(array $data)
    {
        $keys = implode(',', array_keys($data));
        $values = implode(',', array_values($data));
        $result = $this->connection->getPDO()->query("INSERT INTO {$this->table} ($keys) VALUES ($values)");
        return $result->fetch();
    }

    public function update($id, array $data)
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = '$value',";
        }
        $set = rtrim($set, ',');
        $result = $this->connection->getPDO()->query("UPDATE {$this->table} SET $set WHERE id = $id");
        return $result->fetch();
    }

    public function delete($id)
    {
        $result = $this->connection->getPDO()->query("DELETE FROM {$this->table} WHERE id = $id");
        return $result->fetch();
    }
}

