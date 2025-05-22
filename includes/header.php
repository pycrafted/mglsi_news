<?php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../app/Models/Category.php';

$categoryModel = new Category();
$categories = $categoryModel->getAllCategories();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MGLSI News</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Styles de base -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/main.css">
    <!-- Styles spécifiques -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/header.css">
    
    <!-- Styles spécifiques aux pages -->
    <?php 
    $currentPage = $_SERVER['REQUEST_URI'];
    if (strpos($currentPage, '/login') !== false): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/login.css">
    <?php endif; ?>
    
    <?php if (strpos($currentPage, '/admin/dashboard') !== false): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/dashboard.css">
    <?php endif; ?>

    <!-- Debug des chemins CSS -->
    <script>
        console.log('BASE_URL:', '<?php echo BASE_URL; ?>');
        console.log('Current page:', '<?php echo $currentPage; ?>');
        console.log('CSS paths:', [
            '<?php echo BASE_URL; ?>/css/main.css',
            '<?php echo BASE_URL; ?>/css/style.css',
            '<?php echo BASE_URL; ?>/css/header.css'
        ]);
    </script>
</head>
<body>
<header class="site-header">
    <div class="header-main">
        <div class="logo">
            <a href="<?php echo BASE_URL; ?>/">
                <h1>MGLSI News</h1>
            </a>
        </div>
        
        <div class="header-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-menu">
                    <span class="user-greeting">Bienvenue, <?php echo safeHtml($_SESSION['user_name']); ?></span>
                    <div class="user-actions">
                        <a href="<?php echo BASE_URL; ?>/admin/dashboard" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">
                    <i class="fas fa-user"></i>
                    <span>Connexion Journaliste</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <nav class="main-nav">
        <ul>
            <li><a href="<?php echo BASE_URL; ?>/" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a></li>
            <?php foreach ($categories as $cat): ?>
                <li><a href="<?php echo BASE_URL; ?>/?category=<?php echo safeHtml($cat['id']); ?>" class="nav-item">
                    <span><?php echo safeHtml($cat['libelle']); ?></span>
                </a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
</body>
</html>