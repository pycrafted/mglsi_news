<?php
require_once __DIR__ . '/../../config/db_connect.php';

abstract class Model {
    protected $pdo;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct() {
        $this->pdo = getDatabaseConnection();
    }

    public function find(int $id): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findAll(): array {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $fields = array_keys($data);
        $values = array_map(fn($field) => ":$field", $fields);
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $values) . ")";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $fields = array_map(fn($field) => "$field = :$field", array_keys($data));
        
        $sql = "UPDATE {$this->table} 
                SET " . implode(', ', $fields) . " 
                WHERE {$this->primaryKey} = :id";
        
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
} 