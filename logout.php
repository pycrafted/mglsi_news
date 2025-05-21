<?php
// Démarrage de la session pour accéder aux variables de session
session_start();

// Destruction de toutes les variables de session
session_destroy();

// Redirection vers la page d'accueil
header('Location: index.php');
exit; 