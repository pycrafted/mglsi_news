<?php
class ViewHelper {
    public static function safeHtml(string $text): string {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    public static function truncateText(string $text, int $length = 100): string {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }

    public static function formatDate(string $date, string $format = 'd/m/Y à H:i'): string {
        return date($format, strtotime($date));
    }
} 