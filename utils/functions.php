<?php
function safeHtml(string $data): string {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function truncateText(string $text, int $length): string {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

function getAllCategories(PDO $pdo): array {
    $sql = 'SELECT id, libelle FROM Categorie ORDER BY libelle';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Récupère l'article "À la une" (le plus récent)
 */
function getFeaturedArticle(PDO $pdo): ?array {
    $sql = 'SELECT a.id, a.titre, a.contenu, a.image, a.dateCreation, c.libelle AS categorie 
            FROM Article a 
            JOIN Categorie c ON a.categorie = c.id 
            ORDER BY a.dateCreation DESC 
            LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetch() ?: null;
}

/**
 * Récupère les articles avec pagination
 */
function getArticles(PDO $pdo, ?int $categoryId = null, int $page = 1, int $perPage = 10): array {
    $offset = ($page - 1) * $perPage;
    $sql = 'SELECT a.id, a.titre, a.contenu, a.image, a.dateCreation, c.libelle AS categorie 
            FROM Article a 
            JOIN Categorie c ON a.categorie = c.id';
    if ($categoryId !== null) {
        $sql .= ' WHERE a.categorie = :categoryId';
    }
    $sql .= ' ORDER BY a.dateCreation DESC LIMIT :offset, :perPage';
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    if ($categoryId !== null) {
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Compte le nombre total d’articles pour la pagination
 */
function getTotalArticles(PDO $pdo, ?int $categoryId = null): int {
    $sql = 'SELECT COUNT(*) FROM Article a';
    if ($categoryId !== null) {
        $sql .= ' WHERE a.categorie = :categoryId';
    }
    $stmt = $pdo->prepare($sql);
    if ($categoryId !== null) {
        $stmt->execute(['categoryId' => $categoryId]);
    } else {
        $stmt->execute();
    }
    return (int)$stmt->fetchColumn();
}
?>