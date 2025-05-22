<?php
function safeHtml(string $data): string {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function truncateText(string $text, int $length): string {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}
?>