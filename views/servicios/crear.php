

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<h1 class="nombre-pagina">Crear nuevo servicio</h1>
<p class="descripcion-pagina">Rellena los campos para añadir un nuevo servicio</p>

<?php 
    include_once __DIR__ . '/../templates/barra_servicios.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php';?>
    <input type="submit" class="boton-actualizar" value="Guardar Servicio">
</form>