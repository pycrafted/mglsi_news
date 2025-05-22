<?php
class Router {
    private $routes = [];
    private $notFoundCallback;

    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    public function setNotFound($callback) {
        $this->notFoundCallback = $callback;
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace('/mglsi_news', '', $uri);
        
        // Debug logs
        error_log("URI originale: " . $_SERVER['REQUEST_URI']);
        error_log("URI après nettoyage: " . $uri);
        
        // Si l'URI est /index.php, la remplacer par /
        if ($uri === '/index.php') {
            $uri = '/';
        }
        
        $uri = $uri ?: '/';

        // Essayer de trouver une route correspondante
        $matchedRoute = null;
        foreach ($this->routes as $route => $config) {
            // Convertir la route en pattern regex
            $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';
            
            // Debug logs
            error_log("Tentative de correspondance avec la route: " . $route);
            error_log("Pattern regex: " . $pattern);

            if (preg_match($pattern, $uri, $matches)) {
                $matchedRoute = $config;
                // Filtrer les paramètres nommés et les ajouter à $_GET
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                foreach ($params as $key => $value) {
                    $_GET[$key] = $value;
                    error_log("Paramètre ajouté à \$_GET: $key = $value");
                }
                break;
            }
        }

        if ($matchedRoute) {
            $controllerName = $matchedRoute['controller'];
            $actionName = $matchedRoute['action'];
            
            // Debug logs
            error_log("Route trouvée - Controller: $controllerName, Action: $actionName");
            error_log("Paramètres \$_GET: " . print_r($_GET, true));

            // Charger le contrôleur
            $controllerFile = __DIR__ . "/../Controllers/{$controllerName}.php";
            if (!file_exists($controllerFile)) {
                throw new Exception("Contrôleur non trouvé : {$controllerName}");
            }

            require_once $controllerFile;
            $controller = new $controllerName();

            // Vérifier si l'action existe
            if (!method_exists($controller, $actionName)) {
                throw new Exception("Action non trouvée : {$actionName} dans {$controllerName}");
            }

            // Appeler l'action
            return $controller->$actionName();
        }

        // Route non trouvée
        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }

        throw new Exception("Route non trouvée : {$uri}");
    }
} 