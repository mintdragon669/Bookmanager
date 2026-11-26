<?php
require_once __DIR__ . '/../config/bootstrap.php';
requireAuthentication();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit('Identificador de título no válido.');
}

try {
    $fila = Titulo::buscarPorId($id);
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    exit('No fue posible cargar el título. Verifica la conexión y las tablas.');
}

if ($fila === null) {
    http_response_code(404);
    exit('No se encontró el título solicitado.');
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validarCsrfToken()) {
        $error = 'La solicitud expiró o no es válida. Recarga la página e inténtalo de nuevo.';
    } else {
        try {
            if (Titulo::eliminar($id)) {
                header('Location: index.php?estado=eliminado', true, 303);
                exit;
            }
            $error = 'No fue posible eliminar el título.';
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $error = 'No fue posible eliminar el título. Verifica la conexión y la configuración de la base de datos.';
        }
    }
}

$tituloPagina = 'Eliminar título';
require __DIR__ . '/../tiendas/_header.php';
?>
<h1 class="h2 mb-4">Eliminar título</h1>
<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php endif; ?>
<div class="card card-body">
    <p>¿Confirmas que deseas eliminar el título <strong><?= e($fila['titulo']) ?></strong>?</p>
    <p class="text-muted">Esta acción no se puede deshacer.</p>
    <form method="post" class="d-flex gap-2">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <button class="btn btn-danger" type="submit">Sí, eliminar</button>
        <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../tiendas/_footer.php'; ?>
