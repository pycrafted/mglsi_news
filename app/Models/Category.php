<?php
require_once __DIR__ . '/Model.php';

class Category extends Model {
    protected $table = 'Categorie';

    public function getAllCategories(): array {
        return $this->findAll();
    }
}