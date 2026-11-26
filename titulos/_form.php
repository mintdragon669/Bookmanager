<?php
/** @var Titulo $titulo */
/** @var list<array{id_pub: int, nombre_pub: string}> $publicadores */
/** @var array<string, string> $errores */
?>
<div class="mb-3">
    <label class="form-label" for="titulo">Título <span class="text-danger">*</span></label>
    <input class="form-control<?= isset($errores['titulo']) ? ' is-invalid' : '' ?>"
           id="titulo" name="titulo" type="text" maxlength="200" required
           value="<?= e($titulo->getTitulo()) ?>">
    <?php if (isset($errores['titulo'])): ?>
        <div class="invalid-feedback"><?= e($errores['titulo']) ?></div>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label class="form-label" for="precio">Precio <span class="text-danger">*</span></label>
    <input class="form-control<?= isset($errores['precio']) ? ' is-invalid' : '' ?>"
           id="precio" name="precio" type="number" min="0" step="0.01" required
           value="<?= e((string) $titulo->getPrecio()) ?>">
    <?php if (isset($errores['precio'])): ?>
        <div class="invalid-feedback"><?= e($errores['precio']) ?></div>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label class="form-label" for="id_pub">Editorial <span class="text-danger">*</span></label>
    <select class="form-select<?= isset($errores['id_pub']) ? ' is-invalid' : '' ?>"
            id="id_pub" name="id_pub" required>
        <option value="">Selecciona una editorial</option>
        <?php foreach ($publicadores as $publicador): ?>
            <option value="<?= $publicador['id_pub'] ?>"
                <?= $titulo->getIdPub() === $publicador['id_pub'] ? 'selected' : '' ?>>
                <?= e($publicador['nombre_pub']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errores['id_pub'])): ?>
        <div class="invalid-feedback"><?= e($errores['id_pub']) ?></div>
    <?php elseif ($publicadores === []): ?>
        <div class="form-text">Primero registra una editorial en la tabla publicadores.</div>
    <?php endif; ?>
</div>
