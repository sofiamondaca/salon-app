<h1 class="page-name">Nuevo Servicio</h1>
<p class="page-description">Llena todos los campos para añadir un nuevo servicio</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="form">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" value="Guardar Servicio" class="button">
</form>