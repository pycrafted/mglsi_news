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
$categories = $pdo->query('SELECT * FROM Categorie ORDER BY libelle')->fetchAll();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
    $contenu = $_POST['contenu'] ?? '';
    $categorie = filter_input(INPUT_POST, 'categorie', FILTER_VALIDATE_INT);
    
    if ($titre && $contenu && $categorie) {
        $image = '';
        
        // Gestion de l'upload d'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../images/articles/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $newFileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = 'images/articles/' . $newFileName;
                } else {
                    $error = 'Erreur lors de l\'upload de l\'image';
                }
            } else {
                $error = 'Format d\'image non autorisé';
            }
        }
        
        if (!$error) {
            try {
                $stmt = $pdo->prepare('INSERT INTO Article (titre, contenu, image, categorie, auteur) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$titre, $contenu, $image, $categorie, $_SESSION['user_id']]);
                $success = 'Article ajouté avec succès';
                
                // Réinitialisation du formulaire
                $titre = $contenu = '';
                $categorie = null;
            } catch (PDOException $e) {
                $error = 'Erreur lors de l\'ajout de l\'article';
            }
        }
    } else {
        $error = 'Veuillez remplir tous les champs obligatoires';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un article - MGLSI News</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group textarea {
            min-height: 200px;
        }
        .submit-btn {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
        }
        .success-message {
            color: #28a745;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container">
        <div class="form-container">
            <h1>Ajouter un article</h1>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo safeHtml($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo safeHtml($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre :</label>
                    <input type="text" id="titre" name="titre" value="<?php echo safeHtml($titre ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="categorie">Catégorie :</label>
                    <select id="categorie" name="categorie" required>
                        <option value="">Sélectionnez une catégorie</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($categorie ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo safeHtml($cat['libelle']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image">Image :</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                
                <div class="form-group">
                    <label for="contenu">Contenu :</label>
                    <textarea id="contenu" name="contenu" required><?php echo safeHtml($contenu ?? ''); ?></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Publier l'article</button>
            </form>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html> 