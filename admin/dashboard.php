<?php
session_start();
require_once '../config/db_connect.php';
require_once '../utils/functions.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$pdo = getDatabaseConnection();
$articles = $pdo->query('SELECT a.*, c.libelle as categorie_nom, u.nom as auteur_nom 
                        FROM Article a 
                        LEFT JOIN Categorie c ON a.categorie = c.id 
                        LEFT JOIN Utilisateur u ON a.auteur = u.id 
                        ORDER BY a.dateCreation DESC')->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - MGLSI News</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dashboard-container {
            padding: 20px;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .add-article-btn {
            background: #28a745;
            color: white;
            padding: 12px 25px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            min-width: 200px;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .add-article-btn:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .add-article-btn i {
            font-size: 1.2rem;
        }
        .articles-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .articles-table th,
        .articles-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .articles-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        .articles-table tr:hover {
            background-color: #f8f9fa;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: flex-start;
        }
        .action-btn {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background: #007bff;
            color: white;
        }
        .edit-btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .delete-btn {
            background: #dc3545;
            color: white;
        }
        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        .table-responsive {
            overflow-x: auto;
            margin: 0 -20px;
            padding: 0 20px;
        }
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            .add-article-btn {
                text-align: center;
                justify-content: center;
            }
            .action-buttons {
                flex-direction: column;
            }
            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container">
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h1>Tableau de bord</h1>
                <a href="add_article.php" class="add-article-btn">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un article</span>
                </a>
            </div>

            <div class="table-responsive">
                <table class="articles-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Auteur</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?php echo safeHtml($article['titre']); ?></td>
                            <td><?php echo safeHtml($article['categorie_nom']); ?></td>
                            <td><?php echo safeHtml($article['auteur_nom']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($article['dateCreation'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_article.php?id=<?php echo $article['id']; ?>" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i>
                                        <span>Modifier</span>
                                    </a>
                                    <a href="delete_article.php?id=<?php echo $article['id']; ?>" 
                                       class="action-btn delete-btn" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Supprimer</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html> 