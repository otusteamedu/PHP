<?php


namespace App\Database;


class Query
{
    private \PDO $pdo;
    private string $table;
    private string $pk;

    public function __construct(\PDO $pdo, string $table, string $pk)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->pk = $pk;
    }

    public function find($id, array $select = []): ?array
    {
        $result = current($this->findMany([$id], $select));
        return $result ? $result : null;
    }

    public function findMany(array $id, array $select = []): array
    {
        $in = str_repeat('?, ', count($id) - 1) . '?';
        $sql = 'SELECT ' . implode(', ', $select) . ' FROM ' . $this->table . ' WHERE ' . $this->pk . " IN ($in)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function all(array $select = ['*']): array
    {
        $stmt = $this->pdo->prepare('SELECT ' . implode(', ', $select) . ' FROM ' . $this->table);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($id): void
    {
        $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->pk . ' = :pk')->execute([':pk' => $id]);
    }

    public function insert(array $fields): bool
    {
        $bind = [];
        $sql = 'INSERT INTO ' . $this->table . ' (' . implode(', ', array_keys($fields)) . ') VALUES (' . implode(', ', array_map(static function ($v, $k) use (&$bind) {
                $bind[":__$k"] = $v;
                return ":__$k";
            }, $fields, array_keys($fields))) . ')';
        return $this->pdo->prepare($sql)->execute($bind);
    }

    public function update($id, array $fields)
    {
        $bind = [':pk' => $id];
        $sql = 'UPDATE ' . $this->table . ' SET ' . implode(', ', array_map(static function ($v, $k) use (&$bind) {
                $bind[":__$k"] = $v;
                return "$k=:__$k";
            }, $fields, array_keys($fields))) . ' WHERE ' . $this->pk . ' = :pk';
        return $this->pdo->prepare($sql)->execute($bind);
    }

}