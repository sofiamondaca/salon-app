<h1 class="page-name">Crear una nueva cita</h1>
<p class="page-description">Elige tus servicios y coloca tus datos</p>
<div id="app">

<?php
    include_once __DIR__ . '/../templates/bar.php';
?>
    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="step-1" class="section">
        <h2>Servicios</h2>
        <p>Elige tus servicios a continuacion</p>
        <div id="services" class="services-list">

        </div>
    </div>
    <div id="step-2" class="section">
        <h2>Tus Datos y cita</h2>
        <p>Coloca tus datos y fecha de tu cita</p>
        <form class="form">
            <div class="field">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre; ?>"
                    disabled>
            </div>
            <!-- Evitando fecha de un dia anterior con date y strtotime -->
            <div class="field">
                <label for="fecha">Fecha</label>
                <input 
                    type="date"
                    id="fecha"
                    min="<?php echo date('Y-m-d'); ?>">
            </div>


            <div class="field">
                <label for="hora">Hora</label>
                <input 
                    type="time"
                    id="hora">
            </div>
            <input type="hidden" id="id" value="<?php echo $id ?>">
        </form>
    </div>
    <div id="step-3" class="section summary-content">
        <h2>Resumen</h2>
        <p>Verifica que la informacion sea correcta</p>
    </div>

    <div class="pagination">
        <button
            id="previous"
            class="button"
        >&laquo; Anterior</button>
        <button
            id="next"
            class="button"
        >Siguiente &raquo;</button>
    </div>
</div>

<?php
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>";
?>