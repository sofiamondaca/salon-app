<h1 class="page-name">Login</h1>
<p class="page-description">Inicia Sesion con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="form" method="POST" action="/">
    <div class="field">
        <label for="email">Email</label>
        <input 
            type="text"
            id="email"
            placeholder="Tu Email"
            name="email"
            value="<?php echo s($auth->email); ?>"
            />
    </div>

    <div class="field">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            placeholder="Tu contraseña"
            id="password"
            name="password"
            />
    </div>
    <input type="submit" value="Iniciar Sesion" class="button">
</form>

<div class="actions">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea una</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>