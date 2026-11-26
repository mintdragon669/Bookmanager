<?php
/** @var Tienda $tienda */
/** @var array<string, string> $errores */
?>
<div class="mb-3">
    <label class="form-label" for="nombre">Nombre <span class="text-danger">*</span></label>
    <input class="form-control<?= isset($errores['nombre']) ? ' is-invalid' : '' ?>"
           id="nombre" name="nombre" type="text" maxlength="150" required
           value="<?= e($tienda->getNombre()) ?>">
    <?php if (isset($errores['nombre'])): ?>
        <div class="invalid-feedback"><?= e($errores['nombre']) ?></div>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label class="form-label" for="direccion">Dirección</label>
    <input class="form-control" id="direccion" name="direccion" type="text" maxlength="255"
           value="<?= e($tienda->getDireccion()) ?>">
</div>
<div class="mb-3">
    <label class="form-label" for="telefono">Teléfono</label>
    <input class="form-control" id="telefono" name="telefono" type="tel" maxlength="30"
           value="<?= e($tienda->getTelefono()) ?>">
</div>
<div class="mb-3">
    <label class="form-label" for="correo">Correo electrónico</label>
    <input class="form-control<?= isset($errores['correo']) ? ' is-invalid' : '' ?>"
           id="correo" name="correo" type="email" maxlength="150"
           value="<?= e($tienda->getCorreo()) ?>">
    <?php if (isset($errores['correo'])): ?>
        <div class="invalid-feedback"><?= e($errores['correo']) ?></div>
    <?php endif; ?>
</div>
