<h1 class="page-name">Servicios</h1>
<p class="page-description">Administracion de Servicios</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
?>

<ul class="services">
    <?php foreach ($servicios as $servicio): ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>

            <div class="actions">
                <a class="button" href="/servicios/actualizar?id=<?php echo $servicio->id;?>">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id;?>">
                    <input type="submit" value="Borrar" class="delete-button">
                </form>
            </div>
        </li>
    <?php endforeach ?>
</ul>