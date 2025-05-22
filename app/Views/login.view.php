<?php include __DIR__ . '/../../includes/header.php'; ?>

<main class="container">
    <div class="login-container">
        <h1>Connexion Journaliste</h1>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo safeHtml($error); ?></div>
        <?php endif; ?>
        
        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="submit-btn">Se connecter</button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>