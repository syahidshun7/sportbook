<?php
class Model {
    protected PDO $db;
    protected string $table = '';

    public function __construct() {
        $this->db = getDB();
    }

    protected function query(string $sql, array $params = []): PDOStatement {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function findAll(string $where = '', array $params = []): array {
        $sql = "SELECT * FROM {$this->table}" . ($where ? " WHERE $where" : '');
        return $this->query($sql, $params)->fetchAll();
    }

    public function findOne(string $where, array $params): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE $where LIMIT 1";
        $row = $this->query($sql, $params)->fetch();
        return $row ?: null;
    }

    public function findById(int $id): ?array {
        return $this->findOne('id = ?', [$id]);
    }

    public function insert(array $data): int {
        $cols = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $this->query("INSERT INTO {$this->table} ($cols) VALUES ($placeholders)", array_values($data));
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $set = implode(',', array_map(fn($k) => "$k=?", array_keys($data)));
        $this->query("UPDATE {$this->table} SET $set WHERE id=?", [...array_values($data), $id]);
    }

    public function delete(int $id): void {
        $this->query("DELETE FROM {$this->table} WHERE id=?", [$id]);
    }
}
