<?php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../utils/functions.php';

$pdo = getDatabaseConnection();
$categories = getAllCategories($pdo);
?>

<header class="site-header">
    <div class="header-main">
        <div class="logo">
            <a href="/mglsi_news/index.php">
                <h1>MGLSI News</h1>
            </a>
        </div>
        
        <div class="header-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-menu">
                    <span class="user-greeting">Bienvenue, <?php echo safeHtml($_SESSION['user_name']); ?></span>
                    <div class="user-actions">
                        <a href="/mglsi_news/admin/dashboard.php" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="/mglsi_news/logout.php" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/mglsi_news/login.php" class="btn btn-primary">
                    <i class="fas fa-user"></i>
                    <span>Connexion Journaliste</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <nav class="main-nav">
        <ul>
            <li><a href="/mglsi_news/index.php" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a></li>
            <?php foreach ($categories as $cat): ?>
                <li><a href="/mglsi_news/index.php?category=<?php echo $cat['id']; ?>" class="nav-item">
                    <span><?php echo safeHtml($cat['libelle']); ?></span>
                </a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>

<!-- Ajout de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.site-header {
    background: #1a1a1a;
    color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.header-main {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.logo {
    margin-right: auto;
}

.logo a {
    text-decoration: none;
}

.logo h1 {
    color: #fff;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-left: auto;
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.user-greeting {
    color: #e0e0e0;
    font-size: 0.9rem;
    margin-right: 1rem;
}

.user-actions {
    display: flex;
    gap: 1rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn i {
    font-size: 1rem;
}

.btn-primary {
    background: #007bff;
    color: #fff;
}

.btn-danger {
    background: #dc3545;
    color: #fff;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.main-nav {
    background: #2c2c2c;
    padding: 0.5rem 0;
}

.main-nav ul {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    list-style: none;
    display: flex;
    gap: 2rem;
}

.nav-item {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
}

.nav-item:hover, .nav-item.active {
    color: #007bff;
}

.nav-item i {
    font-size: 1rem;
}

@media (max-width: 768px) {
    .header-main {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }

    .header-right {
        width: 100%;
        justify-content: center;
    }

    .user-menu {
        flex-direction: column;
        width: 100%;
    }

    .user-actions {
        width: 100%;
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .main-nav ul {
        flex-wrap: wrap;
        gap: 1rem;
        padding: 0 1rem;
    }

    .nav-item {
        font-size: 0.9rem;
    }
}
</style>