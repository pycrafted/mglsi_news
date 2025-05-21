<?php
// Utilisation d'un chemin absolu
require_once __DIR__ . '/../config/db_connect.php';

$pdo = getDatabaseConnection();

// Création d'un utilisateur de test
$nom = 'Journaliste Test';
$email = 'journaliste@test.com';
$password = password_hash('test123', PASSWORD_DEFAULT);
$role = 'journaliste';

try {
    $stmt = $pdo->prepare('INSERT INTO Utilisateur (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nom, $email, $password, $role]);
    echo "Utilisateur de test créé avec succès !\n";
    echo "Email: journaliste@test.com\n";
    echo "Mot de passe: test123\n";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Code d'erreur pour la violation de contrainte unique
        echo "L'utilisateur existe déjà.\n";
    } else {
        echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage() . "\n";
    }
} 