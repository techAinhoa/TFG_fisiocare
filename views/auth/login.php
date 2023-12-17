
<h1 class="nombre-pagina">Login</h1>
<h2>Bienvenido a FisioCare</h2>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="" class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email"
        id="email"
        placeholder="Correo electronico"
        name="email"
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password"
        id="password"
        placeholder="Contraseña"
        name="password"
        />
    </div>
    <input type="submit" class="boton" value="Iniciar Sesión"/>
</form>
<div class="acciones">
    <a href="/crearCuenta">Click aquí para crear una nueva cuenta</a>
    <a href="/olvidarPass">¿Olvide contraseña?</a>
</div>