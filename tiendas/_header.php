<?php
require_once __DIR__ . '/../config/bootstrap.php';

$tituloPagina = $tituloPagina ?? 'Tiendas';
$basePath = $basePath ?? '..';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($tituloPagina) ?> | Bookmanager</title>
    <link href="<?= e($basePath) ?>/css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="<?= e($basePath) ?>/index.php">Bookmanager</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4" id="sidebarToggle"
            type="button" aria-label="Mostrar u ocultar navegación">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form class="ms-auto me-3 mb-0" action="<?= e($basePath) ?>/logout.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <button class="btn btn-outline-light btn-sm" type="submit">Cerrar sesión</button>
    </form>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Menú</div>
                    <a class="nav-link" href="<?= e($basePath) ?>/index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>Inicio
                    </a>
                    <a class="nav-link" href="<?= e($basePath) ?>/tiendas/index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>Tiendas
                    </a>
                    <a class="nav-link" href="<?= e($basePath) ?>/titulos/index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>Títulos
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">Bookmanager</div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main class="container-fluid px-4 py-4">
