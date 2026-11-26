<?php
require_once __DIR__ . '/../config/bootstrap.php';
requireAuthentication();

$error = null;
$titulos = [];
try {
    $titulos = Titulo::obtenerTodos();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $error = 'No fue posible cargar los títulos. Verifica la conexión y las tablas titulos y publicadores.';
}

$mensajes = [
    'creado' => 'El título se creó correctamente.',
    'actualizado' => 'El título se actualizó correctamente.',
    'eliminado' => 'El título se eliminó correctamente.',
];
$estado = isset($_GET['estado']) && is_string($_GET['estado']) ? $_GET['estado'] : '';
$tituloPagina = 'Títulos';
require __DIR__ . '/../tiendas/_header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Títulos</h1>
    <a class="btn btn-primary" href="crear.php">Nuevo título</a>
</div>
<?php if (isset($mensajes[$estado])): ?>
    <div class="alert alert-success" role="status"><?= e($mensajes[$estado]) ?></div>
<?php endif; ?>
<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php else: ?>
    <div class="card">
        <div class="card-header">Catálogo de libros</div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead><tr>
                    <th scope="col">Título</th>
                    <th scope="col">Editorial</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Acciones</th>
                </tr></thead>
                <tbody>
                <?php if ($titulos === []): ?>
                    <tr><td class="text-center text-muted py-4" colspan="4">Todavía no hay títulos registrados.</td></tr>
                <?php else: ?>
                    <?php foreach ($titulos as $fila): ?>
                        <tr>
                            <td><?= e($fila['titulo']) ?></td>
                            <td><?= e($fila['nombre_pub']) ?></td>
                            <td>$<?= e(number_format((float) $fila['precio'], 2)) ?></td>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="editar.php?id=<?= $fila['id_titulo'] ?>">Editar</a>
                                <a class="btn btn-sm btn-outline-danger"
                                   href="eliminar.php?id=<?= $fila['id_titulo'] ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php require __DIR__ . '/../tiendas/_footer.php'; ?>
