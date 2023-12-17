<div class="campo">
   <label for="nombre">Nombre</label>
    <input 
        type="text"
        id="nombre"
        placeholder="Nombre del servicio"
        name="nombre"
        value= "<?php echo $servicio->nombre;?>"
    />

</div>
<div class="campo">
 <label for="precio">Precio</label>
    <input
        type="text" 
        id="precio"
        placeholder="Precio"
        name="precio"
        value= "<?php echo $servicio->precio; ?>"
        />

</div>
<div class="campo">
 <label for="descripcion">Descripcion</label>
    <textarea 
    name="descripcion" rows="10" cols="30"
    id="descripcion"
    name="descripcion"
   >
    </textarea>
</div>
