<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../models/Tienda.php';
require_once __DIR__ . '/../models/Titulo.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    $https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $https,
        'samesite' => 'Lax',
        'path' => '/',
    ]);
    session_start();
}

function appBasePath(): string
{
    $directory = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
    if (in_array(basename($directory), ['tiendas', 'titulos'], true)) {
        $directory = dirname($directory);
    }

    return rtrim($directory, '/');
}

function isAuthenticated(): bool
{
    return ($_SESSION['authenticated'] ?? false) === true;
}

function requireAuthentication(): void
{
    if (!isAuthenticated()) {
        header('Location: ' . appBasePath() . '/login.php', true, 303);
        exit;
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfToken(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validarCsrfToken(): bool
{
    $token = $_POST['csrf_token'] ?? '';

    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
