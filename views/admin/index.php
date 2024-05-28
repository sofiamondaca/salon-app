<h1 class="page-name">Panel de Administracion</h1>

<?php
    include_once __DIR__ . '/../templates/bar.php';
?>

<div class="search">
    <form action="" class="form">
        <div class="field">
            <label for="fecha">Fecha:</label>
            <input
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha; ?>"
            >
        </div>
    </form>
</div>

<?php
    if (count($citas) === 0) {
        echo "<h2>No hay citas en esta fecha</h2>";
    }
?>

<div id="citas-admin">
    <ul class="appointments">
        <?php
            $idCita = 0; 
            foreach($citas as $key => $cita):
                if ($idCita !== $cita->id):
                    $total = 0;
                    $idCita = $cita->id;
        ?>
                    <li>
                        <p>ID: <span><?php echo $cita->id; ?></span></p>
                        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                        <p>Email: <span><?php echo $cita->email; ?></span></p>
                        <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
                        <h3>Servicios</h3>
            <?php 
                endif;
            ?>
                        <p class="service"><?php echo $cita->servicio . " " . $cita->precio; ?></p>
        <?php 
            $total += $cita->precio;
            // REtorna el id de la cita actual
            $actual = $cita->id;
            // REtorna el id de la cita siguiente
            $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)):
        ?>
                        <p class="total">Total: <span>$ <?php echo $total; ?></span></p>

                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                            <input type="submit" value="Eliminar" class="delete-button">
                        </form>
                    </li>
        <?php      
                endif;
            endforeach;
        ?>
    </ul>

</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>