<?php
// Définir la constante de base URL
define('BASE_URL', '/mglsi_news');

// Point d'entrée principal de l'application
require_once __DIR__ . '/config/db_connect.php';
require_once __DIR__ . '/utils/functions.php';
require_once __DIR__ . '/app/Core/Router.php';

// Charger les routes
$routes = require_once __DIR__ . '/routes/web.php';

// Créer le routeur
$router = new Router($routes);

// Gérer les erreurs 404
$router->setNotFound(function() {
    header("HTTP/1.0 404 Not Found");
    echo "404 - Page non trouvée";
});

// Dispatcher la requête
try {
    $router->dispatch();
} catch (Exception $e) {
    // En production, vous voudrez peut-être logger l'erreur
    echo "Erreur : " . $e->getMessage();
}