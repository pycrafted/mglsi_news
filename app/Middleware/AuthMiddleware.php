<?php
class AuthMiddleware {
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function requireAuth() {
        self::startSession();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public static function isAuthenticated(): bool {
        self::startSession();
        return isset($_SESSION['user_id']);
    }
} 