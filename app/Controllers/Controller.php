<?php
require_once __DIR__ . '/../../utils/functions.php';

abstract class Controller {
    protected function render(string $view, array $data = []): void {
        // Extrait les variables du tableau $data pour les rendre disponibles dans la vue
        extract($data);
        
        // Construit le chemin vers la vue
        $viewPath = __DIR__ . '/../../app/Views/' . $view . '.view.php';
        
        // Vérifie si la vue existe
        if (!file_exists($viewPath)) {
            throw new Exception("Vue non trouvée : $view");
        }
        
        // Inclut la vue
        require_once $viewPath;
    }
    
    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }
} 