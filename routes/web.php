<?php
return [
    // Page d'accueil
    '/' => ['controller' => 'ArticleController', 'action' => 'index'],
    
    // Articles
    '/article' => ['controller' => 'ArticleController', 'action' => 'show'],
    
    // Administration
    '/admin/dashboard' => ['controller' => 'DashboardController', 'action' => 'index'],
    '/admin/article/create' => ['controller' => 'ArticleController', 'action' => 'create'],
    '/admin/article/edit' => ['controller' => 'ArticleController', 'action' => 'edit'],
    '/admin/article/delete' => ['controller' => 'ArticleController', 'action' => 'delete'],
    
    // Authentification
    '/login' => ['controller' => 'AuthController', 'action' => 'login'],
    '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
];