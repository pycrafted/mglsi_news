<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Article.php';
require_once __DIR__ . '/../../utils/functions.php';

class DashboardController extends Controller {
    private $articleModel;

    public function __construct() {
        $this->articleModel = new Article();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $articles = $this->articleModel->getAllArticlesWithDetails();
        $this->render('admin/dashboard', [
            'articles' => $articles
        ]);
    }
}