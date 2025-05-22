<?php
require_once __DIR__ . '/Layout.php';
require_once __DIR__ . '/../Helpers/ViewHelper.php';

class Controller {
    protected function render($view, $data = []) {
        // Construire le chemin vers la vue
        $viewPath = __DIR__ . '/../Views/' . $view . '.view.php';
        
        // Vérifier si la vue existe
        if (!file_exists($viewPath)) {
            throw new Exception("Vue non trouvée : {$view}");
        }
        
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Démarrer la mise en tampon de sortie pour la vue
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        
        // Créer et configurer le layout
        $layout = new Layout();
        $layout->setContent($content);
        $layout->setData($data);
        
        // Rendre le layout
        echo $layout->render();
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
} 