<?php
require_once __DIR__ . '/config/bootstrap.php';

$basePath = '.';
$tituloPagina = 'Inicio';
require __DIR__ . '/tiendas/_header.php';
?>
<h1 class="h2 mb-4">Sistema de gestión de librería</h1>
<p class="lead">Administra el catálogo de libros y la red de tiendas desde un solo lugar.</p>
<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Tiendas</h2>
                <p>Consulta y administra las tiendas.</p>
                <a class="btn btn-primary" href="tiendas/index.php">Ir a tiendas</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Títulos</h2>
                <p>Consulta y administra el catálogo de libros y sus editoriales.</p>
                <a class="btn btn-primary" href="titulos/index.php">Ir a títulos</a>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/tiendas/_footer.php'; ?>
