<?php
require_once 'config/db_connect.php';
require_once 'utils/functions.php';

/**
 * Récupère les détails d'un article spécifique
 * Inclut les informations de catégorie pour l'affichage
 * 
 * @param PDO $pdo Connexion à la base de données
 * @param int $id Identifiant de l'article à récupérer
 * @return array|null Les détails de l'article ou null si non trouvé
 */
function getArticleById(PDO $pdo, int $id): ?array {
    $sql = 'SELECT a.titre, a.contenu, a.image, a.dateCreation, c.libelle AS categorie 
            FROM Article a 
            JOIN Categorie c ON a.categorie = c.id 
            WHERE a.id = :id';
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch() ?: null;
}

// Vérification et validation de l'ID de l'article
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    die('ID d\'article invalide');
}

// Récupération des données de l'article
$pdo = getDatabaseConnection();
$article = getArticleById($pdo, $id);

// Vérification que l'article existe
if (!$article) {
    http_response_code(404);
    die('Article non trouvé');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo safeHtml($article['titre']); ?> - MGLSI News</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">
        <article class="article-detail">
            <!-- Navigation de retour -->
            <nav class="article-nav">
                <a href="index.php" class="back-link">← Retour aux actualités</a>
            </nav>

            <!-- En-tête de l'article avec titre et métadonnées -->
            <header class="article-header">
                <h1><?php echo safeHtml($article['titre']); ?></h1>
                <p class="meta">
                    <span class="category"><?php echo safeHtml($article['categorie']); ?></span> | 
                    Publié le <?php echo date('d/m/Y à H:i', strtotime($article['dateCreation'])); ?>
                </p>
            </header>

            <!-- Corps de l'article avec image et contenu -->
            <div class="article-body">
                <?php if ($article['image']): ?>
                    <figure class="article-image">
                        <img src="<?php echo safeHtml($article['image']); ?>" alt="<?php echo safeHtml($article['titre']); ?>">
                        <figcaption><?php echo safeHtml($article['titre']); ?></figcaption>
                    </figure>
                <?php endif; ?>
                <div class="article-content">
                    <p><?php echo nl2br(safeHtml($article['contenu'])); ?></p>
                </div>
            </div>
        </article>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>