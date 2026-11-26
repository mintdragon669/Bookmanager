<?php
declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validarCsrfToken()) {
    http_response_code(400);
    exit('Solicitud no válida.');
}

$_SESSION = [];
session_regenerate_id(true);
header('Location: ' . appBasePath() . '/login.php', true, 303);
exit;
