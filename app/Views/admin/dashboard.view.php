<?php include __DIR__ . '/../../../includes/header.php'; ?>

<main class="container">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Tableau de bord</h1>
            <a href="<?php echo BASE_URL; ?>/admin/article/create" class="add-article-btn">
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
                                <a href="<?php echo BASE_URL; ?>/admin/article/edit?id=<?php echo $article['id']; ?>" class="action-btn edit-btn">
                                    <i class="fas fa-edit"></i>
                                    <span>Modifier</span>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/admin/article/delete?id=<?php echo $article['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                    <i class="fas fa-trash"></i>
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

<?php include __DIR__ . '/../../../includes/footer.php'; ?>