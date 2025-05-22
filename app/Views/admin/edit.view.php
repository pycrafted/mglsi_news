<?php include __DIR__ . '/../../../includes/header.php'; ?>

<main class="container">
    <div class="form-container">
        <h1>Modifier l'article</h1>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo safeHtml($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message"><?php echo safeHtml($success); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" value="<?php echo safeHtml($article['titre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="categorie">Catégorie :</label>
                <select id="categorie" name="categorie" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $article['categorie'] == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo safeHtml($cat['libelle']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if ($article['image']): ?>
                    <p>Image actuelle : <img src="<?php echo BASE_URL . '/' . $article['image']; ?>" alt="Image actuelle" style="max-width: 100px;"></p>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="contenu">Contenu :</label>
                <textarea id="contenu" name="contenu" required><?php echo safeHtml($article['contenu']); ?></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Mettre à jour l'article</button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../../../includes/footer.php'; ?>