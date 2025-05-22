<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../utils/functions.php';

class AuthController extends Controller {
    public function login() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/admin/dashboard');
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($email && $password) {
                $pdo = getDatabaseConnection();
                $stmt = $pdo->prepare('SELECT * FROM Utilisateur WHERE email = ?');
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['mot_de_passe'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['nom'];
                    $_SESSION['user_role'] = $user['role'];
                    $this->redirect(BASE_URL . '/admin/dashboard');
                } else {
                    $error = 'Email ou mot de passe incorrect';
                }
            } else {
                $error = 'Veuillez remplir tous les champs';
            }
        }

        $this->render('login', ['error' => $error]);
    }

    public function logout() {
        session_start();
        session_destroy();
        $this->redirect(BASE_URL . '/');
    }
}