<h1 class="nombre-pagina">Crea una cuenta</h1>
<p class="descripcion-pagina">Rellena el siguiente formulario para crear una cuenta</p>
<?php
    include_once __DIR__."/../templates/alertas.php";
   
?>
<form class="formulario" method="POST" action="/crearCuenta"  >
<div class="campo">
    <label for="nombre">Nombre</label>
    <input 
    type="text" 
    name="nombre" 
    id="nombre"
    placeholder="Nombre*"
    value="<?php echo s($usuario->nombre)?>"
    />
    <
</div>
<div class="campo">
    <label for="apellido">Apellido</label>
    <input 
    type="text" 
    name="apellido" 
    id="apellido"
    placeholder="Apellido*"
    value="<?php echo s($usuario->apellido)?>"/>
</div>
<div class="campo">
    <label for="Telefono">Teléfono</label>
    <input 
    type="tel" 
    name="telefono" 
    id="telefono"
    placeholder="Telefono*"
    value="<?php echo s($usuario->telefono)?>"/>
</div>
<div class="campo">
    <label for="email">Correo electrónico</label>
    <input 
    type="email" 
    name="email" 
    id="email"
    placeholder="Correo electrónico*"
    value="<?php echo s($usuario->email)?>"/>
</div>
<div class="campo">
    <label for="password">Contraseña</label>
    <input 
    type="password" 
    name="password" 
    id="password"
    placeholder="Contraseña*"/>
</div>
<input type="submit" value="Crear Cuenta" class="boton"/>
</form>
<div class="acciones">
    <a href="/">¿ Ya tienes una cuenta ? Inicia sesión</a>
    <a href="/olvidarPass">¿Olvide contraseña?</a>
</div>