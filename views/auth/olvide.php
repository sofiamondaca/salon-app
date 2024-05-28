<h1 class="page-name">Olvide mi contraseña</h1>
<p class="page-description">Reestablece tu contraseña ingresando tu correo electronico.</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form method="POST" action="/olvide" class="form">
    <div class="field">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu email">
    </div>
    <input type="submit" value="Enviar instrucciones" class="button">
</form>

<div class="actions">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesion</a>
    <a href="/crear-cuenta">¿No tienes una cuenta? Crea una cuenta</a>
</div>