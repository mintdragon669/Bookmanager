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
    $publicadores = Titulo::obtenerPublicadores();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    exit('No fue posible cargar el título o sus editoriales. Verifica la conexión y las tablas.');
}

if ($fila === null) {
    http_response_code(404);
    exit('No se encontró el título solicitado.');
}

$titulo = new Titulo($fila['titulo'], (float) $fila['precio'], (int) $fila['id_pub'], $id);
$errores = [];
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo->setTitulo(trim((string) ($_POST['titulo'] ?? '')));
    $titulo->setPrecio((float) ($_POST['precio'] ?? 0));
    $titulo->setIdPub(filter_var($_POST['id_pub'] ?? null, FILTER_VALIDATE_INT) ?: null);

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

    if ($errores === []) {
        try {
            if ($titulo->actualizar()) {
                header('Location: index.php?estado=actualizado', true, 303);
                exit;
            }
            $error = 'No fue posible actualizar el título.';
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $error = 'No fue posible actualizar el título. Verifica la conexión y los datos de la editorial.';
        }
    }
}

$tituloPagina = 'Editar título';
require __DIR__ . '/../tiendas/_header.php';
?>
<h1 class="h2 mb-4">Editar título</h1>
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
        <button class="btn btn-primary" type="submit">Guardar cambios</button>
        <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </div>
</form>
<?php require __DIR__ . '/../tiendas/_footer.php'; ?>
