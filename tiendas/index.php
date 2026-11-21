<?php
require_once __DIR__ . '/../config/bootstrap.php';

$error = null;
$tiendas = [];
try {
    $tiendas = Tienda::obtenerTodas();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $error = 'No fue posible cargar las tiendas. Verifica la conexión y la configuración de la base de datos.';
}

$mensajes = [
    'creada' => 'La tienda se creó correctamente.',
    'actualizada' => 'La tienda se actualizó correctamente.',
    'eliminada' => 'La tienda se eliminó correctamente.',
];
$estado = isset($_GET['estado']) && is_string($_GET['estado']) ? $_GET['estado'] : '';
$tituloPagina = 'Tiendas';
require __DIR__ . '/_header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Tiendas</h1>
    <a class="btn btn-primary" href="crear.php">Nueva tienda</a>
</div>

<?php if (isset($mensajes[$estado])): ?>
    <div class="alert alert-success" role="status"><?= e($mensajes[$estado]) ?></div>
<?php endif; ?>
<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php else: ?>
    <div class="card">
        <div class="card-header">Listado de tiendas</div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($tiendas === []): ?>
                    <tr><td class="text-center text-muted py-4" colspan="5">Todavía no hay tiendas registradas.</td></tr>
                <?php else: ?>
                    <?php foreach ($tiendas as $tienda): ?>
                        <tr>
                            <td><?= e($tienda->getNombre()) ?></td>
                            <td><?= e($tienda->getDireccion()) ?></td>
                            <td><?= e($tienda->getTelefono()) ?></td>
                            <td><?= e($tienda->getCorreo()) ?></td>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="editar.php?id=<?= $tienda->getId() ?>">Editar</a>
                                <a class="btn btn-sm btn-outline-danger"
                                   href="eliminar.php?id=<?= $tienda->getId() ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php require __DIR__ . '/_footer.php'; ?>
