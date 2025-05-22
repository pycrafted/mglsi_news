<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Article.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../../utils/functions.php';

class ArticleController extends Controller {
    private $articleModel;
    private $categoryModel;

    public function __construct() {
        $this->articleModel = new Article();
        $this->categoryModel = new Category();
    }

    public function index() {
        session_start();
        $selectedCategory = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        $perPage = 10;

        $categories = $this->categoryModel->getAllCategories();
        $featured = $this->articleModel->getFeaturedArticle();
        $articles = $this->articleModel->getArticles($selectedCategory, $page, $perPage);
        $totalArticles = $this->articleModel->getTotalArticles($selectedCategory);
        $totalPages = ceil($totalArticles / $perPage);

        // Debug information
        if ($featured) {
            error_log("Featured article image path: " . $featured['image']);
            error_log("Full featured image path: " . __DIR__ . '/../../' . $featured['image']);
            error_log("Featured image exists: " . (file_exists(__DIR__ . '/../../' . $featured['image']) ? 'yes' : 'no'));
        }
        foreach ($articles as $article) {
            if (!empty($article['image'])) {
                error_log("Article {$article['id']} image path: " . $article['image']);
                error_log("Full article image path: " . __DIR__ . '/../../' . $article['image']);
                error_log("Article image exists: " . (file_exists(__DIR__ . '/../../' . $article['image']) ? 'yes' : 'no'));
            }
        }

        $this->render('index', [
            'categories' => $categories,
            'featured' => $featured,
            'articles' => $articles,
            'page' => $page,
            'totalPages' => $totalPages,
            'selectedCategory' => $selectedCategory
        ]);
    }

    public function show() {
        session_start();
        
        // Debug logs
        error_log("Méthode show() appelée");
        error_log("GET params: " . print_r($_GET, true));
        
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        error_log("ID après filter_input: " . var_export($id, true));
        
        if ($id === false || $id === null) {
            error_log("ID invalide détecté");
            http_response_code(400);
            die('ID d\'article invalide');
        }

        $article = $this->articleModel->getArticleById($id);
        error_log("Article trouvé: " . ($article ? 'oui' : 'non'));
        
        if (!$article) {
            error_log("Article non trouvé pour l'ID: " . $id);
            http_response_code(404);
            die('Article non trouvé');
        }

        $this->render('article', [
            'article' => $article
        ]);
    }

    public function create() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $categories = $this->categoryModel->getAllCategories();
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
            $contenu = $_POST['contenu'] ?? '';
            $categorie = filter_input(INPUT_POST, 'categorie', FILTER_VALIDATE_INT);

            if ($titre && $contenu && $categorie) {
                $image = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../images/articles/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($fileExtension, $allowedExtensions)) {
                        $newFileName = uniqid() . '.' . $fileExtension;
                        $uploadFile = $uploadDir . $newFileName;
                        error_log("Tentative d'upload vers : " . $uploadFile);
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                            $image = 'images/articles/' . $newFileName;
                            error_log("Image uploadée avec succès : " . $image);
                        } else {
                            $error = 'Erreur lors de l\'upload de l\'image';
                            error_log("Erreur lors de l'upload : " . error_get_last()['message']);
                        }
                    } else {
                        $error = 'Format d\'image non autorisé';
                        error_log("Format d'image non autorisé : " . $fileExtension);
                    }
                }

                if (!$error) {
                    $data = [
                        'titre' => $titre,
                        'contenu' => $contenu,
                        'image' => $image,
                        'categorie' => $categorie,
                        'auteur' => $_SESSION['user_id']
                    ];
                    $this->articleModel->create($data);
                    $success = 'Article ajouté avec succès';
                }
            } else {
                $error = 'Veuillez remplir tous les champs obligatoires';
            }
        }

        $this->render('admin/create', [
            'categories' => $categories,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function edit() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            http_response_code(400);
            die('ID d\'article invalide');
        }

        $article = $this->articleModel->getArticleById($id);
        if (!$article) {
            http_response_code(404);
            die('Article non trouvé');
        }

        $categories = $this->categoryModel->getAllCategories();
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
            $contenu = $_POST['contenu'] ?? '';
            $categorie = filter_input(INPUT_POST, 'categorie', FILTER_VALIDATE_INT);

            if ($titre && $contenu && $categorie) {
                $image = $article['image'];
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../images/articles/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($fileExtension, $allowedExtensions)) {
                        $newFileName = uniqid() . '.' . $fileExtension;
                        $uploadFile = $uploadDir . $newFileName;
                        error_log("Tentative d'upload vers : " . $uploadFile);
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                            $image = 'images/articles/' . $newFileName;
                            error_log("Image uploadée avec succès : " . $image);
                        } else {
                            $error = 'Erreur lors de l\'upload de l\'image';
                            error_log("Erreur lors de l'upload : " . error_get_last()['message']);
                        }
                    } else {
                        $error = 'Format d\'image non autorisé';
                        error_log("Format d'image non autorisé : " . $fileExtension);
                    }
                }

                if (!$error) {
                    $data = [
                        'titre' => $titre,
                        'contenu' => $contenu,
                        'image' => $image,
                        'categorie' => $categorie
                    ];
                    $this->articleModel->update($id, $data);
                    $success = 'Article modifié avec succès';
                    $article = $this->articleModel->getArticleById($id);
                }
            } else {
                $error = 'Veuillez remplir tous les champs obligatoires';
            }
        }

        $this->render('admin/edit', [
            'article' => $article,
            'categories' => $categories,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function delete() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            http_response_code(400);
            die('ID d\'article invalide');
        }

        $this->articleModel->delete($id);
        $this->redirect(BASE_URL . '/admin/dashboard');
    }
}