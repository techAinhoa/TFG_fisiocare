
<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<h1 class="nombre-pagina">Actualizar servicios</h1>


<?php 
    include_once __DIR__ . '/../templates/barra_servicios.php';
?>
<p class="descripcion-pagina">Rellena los campos para actualizar</p>
<form  method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php';?>
    <input type="submit" class="boton-actualizar" value="Actualizar">
</form>