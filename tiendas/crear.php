<?php
require_once __DIR__ . '/../config/bootstrap.php';
requireAuthentication();

$tienda = new Tienda();
$errores = [];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tienda = new Tienda(
        trim((string) ($_POST['nombre'] ?? '')),
        trim((string) ($_POST['direccion'] ?? '')),
        trim((string) ($_POST['telefono'] ?? '')),
        trim((string) ($_POST['correo'] ?? ''))
    );

    if (!validarCsrfToken()) {
        $errores['general'] = 'La solicitud expiró o no es válida. Recarga la página e inténtalo de nuevo.';
    } elseif ($tienda->getNombre() === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif ($tienda->getCorreo() !== '' && filter_var($tienda->getCorreo(), FILTER_VALIDATE_EMAIL) === false) {
        $errores['correo'] = 'Ingresa un correo electrónico válido.';
    }

    if ($errores === []) {
        try {
            if ($tienda->crear()) {
                header('Location: index.php?estado=creada', true, 303);
                exit;
            }
            $error = 'No fue posible guardar la tienda.';
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $error = 'No fue posible guardar la tienda. Verifica la conexión y la configuración de la base de datos.';
        }
    }
}

$tituloPagina = 'Crear tienda';
require __DIR__ . '/_header.php';
?>
<h1 class="h2 mb-4">Crear tienda</h1>
<?php if (isset($errores['general'])): ?>
    <div class="alert alert-danger" role="alert"><?= e($errores['general']) ?></div>
<?php endif; ?>
<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php endif; ?>
<form method="post" class="card card-body" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
    <?php require __DIR__ . '/_form.php'; ?>
    <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </div>
</form>
<?php require __DIR__ . '/_footer.php'; ?>
