<h1 class="nombre-pagina">Recuperar contraseña</h1>
<p class="descripcion-pagina">Introduce tu nuevo password a continuación</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php 
//si el token no existe o es erroneo error será true y no devolvera el form
if($error) return;?>


<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password" 
            id="password"
            name="password" 
            placeholder="Nueva Contraseña"    
        />
    </div>
    <input type="submit" class="boton" value="Guardar nueva contraseña">
    </form>
    <div class="acciones"> 
        <a href="/">¿Ya tienes cuenta? Inciar Sesión</a>
        <a href="/crearCuenta">¿Todavía no tienes una cuenta?Obtener una</a>
    </div>
