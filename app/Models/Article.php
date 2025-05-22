<?php
require_once __DIR__ . '/Model.php';

class Article extends Model {
    protected $table = 'Article';

    public function getFeaturedArticle(): ?array {
        $sql = 'SELECT a.id, a.titre, a.contenu, a.image, a.dateCreation, c.libelle AS categorie 
                FROM Article a 
                JOIN Categorie c ON a.categorie = c.id 
                ORDER BY a.dateCreation DESC 
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }

    public function getArticles(?int $categoryId = null, int $page = 1, int $perPage = 10): array {
        $offset = ($page - 1) * $perPage;
        $sql = 'SELECT a.id, a.titre, a.contenu, a.image, a.dateCreation, c.libelle AS categorie 
                FROM Article a 
                JOIN Categorie c ON a.categorie = c.id';
        if ($categoryId !== null) {
            $sql .= ' WHERE a.categorie = :categoryId';
        }
        $sql .= ' ORDER BY a.dateCreation DESC LIMIT :offset, :perPage';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        if ($categoryId !== null) {
            $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalArticles(?int $categoryId = null): int {
        $sql = 'SELECT COUNT(*) FROM Article a';
        if ($categoryId !== null) {
            $sql .= ' WHERE a.categorie = :categoryId';
        }
        $stmt = $this->pdo->prepare($sql);
        if ($categoryId !== null) {
            $stmt->execute(['categoryId' => $categoryId]);
        } else {
            $stmt->execute();
        }
        return (int)$stmt->fetchColumn();
    }

    public function getArticleById(int $id): ?array {
        $sql = 'SELECT a.id, a.titre, a.contenu, a.image, a.dateCreation, c.libelle AS categorie 
                FROM Article a 
                JOIN Categorie c ON a.categorie = c.id 
                WHERE a.id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function getAllArticlesWithDetails(): array {
        $sql = 'SELECT a.*, c.libelle as categorie_nom, u.nom as auteur_nom 
                FROM Article a 
                LEFT JOIN Categorie c ON a.categorie = c.id 
                LEFT JOIN Utilisateur u ON a.auteur = u.id 
                ORDER BY a.dateCreation DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}