<?php
session_start();
require_once 'config/db_connect.php';
require_once 'utils/functions.php';

// Initialisation de la connexion et récupération des données
$pdo = getDatabaseConnection();
$categories = getAllCategories($pdo);

// Récupération des paramètres de filtrage et pagination
$selectedCategory = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
$perPage = 10;

// Récupération des articles
$featured = getFeaturedArticle($pdo);  // Article à la une
$articles = getArticles($pdo, $selectedCategory, $page, $perPage);  // Liste des articles
$totalArticles = getTotalArticles($pdo, $selectedCategory);  // Nombre total d'articles
$totalPages = ceil($totalArticles / $perPage);  // Calcul du nombre de pages
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités MGLSI</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">
        <!-- Section principale : Article à la une -->
        <?php if ($featured): ?>
            <section class="featured">
                <h1>À la une</h1>
                <div class="featured-article">
                    <img src="<?php echo safeHtml($featured['image']); ?>" alt="<?php echo safeHtml($featured['titre']); ?>">
                    <div class="featured-content">
                        <h2><?php echo safeHtml($featured['titre']); ?></h2>
                        <p><?php echo truncateText(safeHtml($featured['contenu']), 200); ?></p>
                        <a href="article.php?id=<?php echo $featured['id']; ?>" class="read-more">Lire l'article</a>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <div class="content-wrapper">
            <!-- Section des articles récents -->
            <section class="articles">
                <h2>Dernières nouvelles</h2>
                <?php foreach ($articles as $article): ?>
                    <article class="article-card">
                        <img src="<?php echo safeHtml($article['image']); ?>" alt="<?php echo safeHtml($article['titre']); ?>">
                        <div class="article-content">
                            <h3><?php echo safeHtml($article['titre']); ?></h3>
                            <p class="category"><?php echo safeHtml($article['categorie']); ?></p>
                            <p><?php echo truncateText(safeHtml($article['contenu']), 100); ?></p>
                            <a href="article.php?id=<?php echo $article['id']; ?>" class="read-more">Lire la suite</a>
                        </div>
                    </article>
                <?php endforeach; ?>

                <!-- Navigation entre les pages -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?><?php echo $selectedCategory ? '&category=' . $selectedCategory : ''; ?>">Précédent</a>
                    <?php endif; ?>
                    <span>Page <?php echo $page; ?> sur <?php echo $totalPages; ?></span>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?><?php echo $selectedCategory ? '&category=' . $selectedCategory : ''; ?>">Suivant</a>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Barre latérale : Espace publicitaire -->
            <aside class="sidebar">
                <h3>Publicités</h3>
                <div class="ad">
                    <a href="https://example.com" target="_blank">
                        <img src="images/pub1.jpg" alt="Publicité verticale">
                    </a>
                </div>
                <div class="ad">
                    <a href="https://example.com" target="_blank">
                        <img src="images/pub2.jpg" alt="Publicité carrée">
                    </a>
                </div>
                <div class="ad">
                    <a href="https://example.com" target="_blank">
                        <img src="images/pub3.jpg" alt="Publicité rond">
                    </a>
                </div>
            </aside>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>