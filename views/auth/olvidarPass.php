<h1 class="nombre-pagina">Olvide contraseña</h1>
<p class="descripcion-pagina">Introduce tu correo para restablecer la contraseña</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" action="/olvidarPass" method="POST">
    <div class="campo">
    <label for="email">Correo electrónico</label>
    <input type="email" 
    name="email" 
    id="email" 
    placeholder="Correo electrónico"/>
    </div>
    <input type="submit" class="boton" value="Enviar"/>
</form>
<div class="acciones">
    <a href="/">¿ Ya tienes una cuenta ? Inicia sesión</a>
    <a href="/crearCuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>