<?php
session_start();
require_once 'config/db_connect.php';
require_once 'utils/functions.php';

// Initialisation de la variable d'erreur
$error = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données du formulaire
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Vérification que tous les champs sont remplis
    if ($email && $password) {
        $pdo = getDatabaseConnection();
        
        // Recherche de l'utilisateur dans la base de données
        $stmt = $pdo->prepare('SELECT * FROM Utilisateur WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Vérification du mot de passe et connexion
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Stockage des informations de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            $_SESSION['user_role'] = $user['role'];
            
            // Redirection vers le tableau de bord
            header('Location: admin/dashboard.php');
            exit;
        } else {
            $error = 'Email ou mot de passe incorrect';
        }
    } else {
        $error = 'Veuillez remplir tous les champs';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MGLSI News</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Style du conteneur de connexion */
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Style du formulaire de connexion */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Style des groupes de champs */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Style des messages d'erreur */
        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
        }

        /* Style du bouton de connexion */
        .submit-btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">
        <div class="login-container">
            <h1>Connexion Journaliste</h1>
            
            <!-- Affichage des messages d'erreur -->
            <?php if ($error): ?>
                <div class="error-message"><?php echo safeHtml($error); ?></div>
            <?php endif; ?>
            
            <!-- Formulaire de connexion -->
            <form class="login-form" method="POST" action="">
                <!-- Champ email -->
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <!-- Champ mot de passe -->
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <!-- Bouton de connexion -->
                <button type="submit" class="submit-btn">Se connecter</button>
            </form>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 