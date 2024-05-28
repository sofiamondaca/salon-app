
<div class="bar">
    <p>Hola: <?php echo $nombre ?? ''; ?></p>

    <a href="/logout" class="button">Cerrar Sesion</a>
</div>

<?php if(isset($_SESSION['admin'])){ ?>
    <div class="services-bar">
        <a href="/admin" class="button">Ver Citas</a>
        <a href="/servicios" class="button">Ver Servicios</a>
        <a href="/servicios/crear" class="button">Nuevo Servicio</a>
    </div>
<?php } ?>