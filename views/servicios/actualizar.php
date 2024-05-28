<h1 class="page-name">Actualizar servicios</h1>
<p class="page-description">Administracion de Servicios</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<!-- Se elimina el Action porque para actualizar se manda algo ocmo /servicios/actualizar/?iddelservicio -->
<!-- Y nuestro router no soporta eso -->
<!-- pero si se borra del form -->
<!-- Se manda al url por defecto -->
<form method="POST" class="form">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" value="Actualizar" class="button">
</form>