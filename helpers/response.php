<?php
/**
 * JSON response helper for AJAX and API endpoints.
 */

function json_response(bool $ok, string $message, array $extra = [], int $status = 200): void
{
    if (!headers_sent()) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
    }

    echo json_encode(array_merge([
        'ok' => $ok,
        'message' => $message,
    ], $extra), JSON_UNESCAPED_UNICODE);
    exit();
}
