<?php
declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

if (isAuthenticated()) {
    header('Location: ' . appBasePath() . '/index.php', true, 303);
    exit;
}

$error = null;
$username = getenv('APP_USERNAME');
$passwordHash = getenv('APP_PASSWORD_HASH');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $providedUsername = $_POST['username'] ?? '';
    $providedPassword = $_POST['password'] ?? '';

    if (!validarCsrfToken()) {
        $error = 'La sesión del formulario expiró. Recarga la página e inténtalo de nuevo.';
    } elseif (!is_string($username) || $username === '' || !is_string($passwordHash) || $passwordHash === '') {
        $error = 'El acceso no está configurado. Define APP_USERNAME y APP_PASSWORD_HASH en el hosting.';
    } elseif (
        is_string($providedUsername)
        && is_string($providedPassword)
        && hash_equals($username, $providedUsername)
        && password_verify($providedPassword, $passwordHash)
    ) {
        session_regenerate_id(true);
        $_SESSION['authenticated'] = true;
        unset($_SESSION['csrf_token']);
        header('Location: ' . appBasePath() . '/index.php', true, 303);
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Bookmanager</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5" style="max-width: 32rem">
    <h1 class="h2 mb-4">Bookmanager</h1>
    <?php if ($error !== null): ?>
        <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <div class="mb-3">
            <label class="form-label" for="username">Usuario</label>
            <input class="form-control" id="username" name="username" type="text"
                   autocomplete="username" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Contraseña</label>
            <input class="form-control" id="password" name="password" type="password"
                   autocomplete="current-password" required>
        </div>
        <button class="btn btn-primary" type="submit">Iniciar sesión</button>
    </form>
</main>
</body>
</html>
