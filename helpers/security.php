<?php
/**
 * Session, XSS escaping, CSRF protection, and role-based access helpers.
 */

function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        if (!headers_sent()) {
            session_set_cookie_params([
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }
        session_start();
    }
}

/**
 * Escape text for safe HTML output.
 */
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Get or initialize the session CSRF token.
 */
function csrf_token(): string
{
    start_secure_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden CSRF input field.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/**
 * Verify submitted CSRF token against session token.
 */
function verify_csrf(?string $token): bool
{
    start_secure_session();
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Enforce authentication and optional role check.
 */
function require_auth(?string $requiredRole = null, string $loginUrl = 'login.php'): void
{
    start_secure_session();

    $uname = $_SESSION['uname'] ?? '';
    $role = $_SESSION['role'] ?? '';

    if ($uname === '') {
        header('Location: ' . $loginUrl);
        exit();
    }

    if ($requiredRole !== null && $role !== $requiredRole) {
        if ($role === 'admin') {
            header('Location: ../admin/index.php');
        } elseif ($role === 'salon') {
            header('Location: ../salon/index.php');
        } else {
            header('Location: ' . $loginUrl);
        }
        exit();
    }
}

/**
 * Store a flash message and redirect immediately.
 */
function redirect_with_flash(string $url, string $key, string $message): void
{
    start_secure_session();
    $_SESSION[$key] = $message;
    header('Location: ' . $url);
    exit();
}
