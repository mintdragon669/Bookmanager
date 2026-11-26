<?php
require_once __DIR__ . '/../config/bootstrap.php';
requireAuthentication();

$titulo = new Titulo();
$errores = [];
$error = null;
$publicadores = [];
try {
    $publicadores = Titulo::obtenerPublicadores();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $error = 'No fue posible cargar las editoriales. Verifica la tabla publicadores.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = new Titulo(
        trim((string) ($_POST['titulo'] ?? '')),
        (float) ($_POST['precio'] ?? 0),
        filter_var($_POST['id_pub'] ?? null, FILTER_VALIDATE_INT) ?: null
    );

    if (!validarCsrfToken()) {
        $errores['general'] = 'La solicitud expiró o no es válida. Recarga la página e inténtalo de nuevo.';
    } elseif ($titulo->getTitulo() === '') {
        $errores['titulo'] = 'El título es obligatorio.';
    } elseif (!is_numeric($_POST['precio'] ?? null) || (float) $_POST['precio'] < 0) {
        $errores['precio'] = 'El precio debe ser un número mayor o igual a cero.';
    } elseif ($titulo->getIdPub() === null) {
        $errores['id_pub'] = 'Selecciona una editorial válida.';
    } elseif (!in_array($titulo->getIdPub(), array_column($publicadores, 'id_pub'), true)) {
        $errores['id_pub'] = 'La editorial seleccionada no existe.';
    }

    if ($errores === [] && $error === null) {
        try {
            if ($titulo->crear()) {
                header('Location: index.php?estado=creado', true, 303);
                exit;
            }
            $error = 'No fue posible guardar el título.';
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $error = 'No fue posible guardar el título. Verifica la conexión y los datos de la editorial.';
        }
    }
}

$tituloPagina = 'Crear título';
require __DIR__ . '/../tiendas/_header.php';
?>
<h1 class="h2 mb-4">Crear título</h1>
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
        <button class="btn btn-primary" type="submit" <?= $publicadores === [] ? 'disabled' : '' ?>>Guardar</button>
        <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </div>
</form>
<?php require __DIR__ . '/../tiendas/_footer.php'; ?>
