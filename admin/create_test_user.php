<?php
// Inclusion du fichier de configuration de la base de données
require_once __DIR__ . '/../config/db_connect.php';

// Connexion à la base de données
$pdo = getDatabaseConnection();

// Configuration de l'utilisateur de test
$nom = 'Journaliste Test';
$email = 'journaliste@test.com';
$password = password_hash('test123', PASSWORD_DEFAULT);  // Hashage sécurisé du mot de passe
$role = 'journaliste';

try {
    // Tentative d'insertion de l'utilisateur dans la base de données
    $stmt = $pdo->prepare('INSERT INTO Utilisateur (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nom, $email, $password, $role]);
    
    // Affichage des informations de connexion en cas de succès
    echo "Utilisateur de test créé avec succès !\n";
    echo "Email: journaliste@test.com\n";
    echo "Mot de passe: test123\n";
} catch (PDOException $e) {
    // Gestion des erreurs
    if ($e->getCode() == 23000) {  // Code d'erreur pour la violation de contrainte unique
        echo "L'utilisateur existe déjà.\n";
    } else {
        echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage() . "\n";
    }
} 