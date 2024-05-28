<h1 class="page-name">Recuperar tu contraseña</h1>
<p class="page-description">Coloca tu nueva contraseña a continuacion</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if($error) return null; ?>
<form method="POST" class="form">
    <div class="field">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu nueva contraseña"/>
    </div>
    <input type="submit" value="Guardar nueva contraseña" class="button">
</form>

<div class="actions">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesion</a>
    <a href="/crear-cuenta">¿No tienes una cuenta? Crea una cuenta</a>
</div>