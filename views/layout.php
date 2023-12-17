<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FisioCare citas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Caveat:wght@600&family=Itim&family=Petrona:ital,wght@1,300;1,700&family=Shadows+Into+Light&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Caveat:wght@600&family=Itim&family=Petrona:ital,wght@1,300;1,700&family=Shadows+Into+Light&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
    <style>
        /* Estilos básicos para el mapa y el footer */
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            height: 300px; /* Ajusta la altura según tus necesidades */
            width: 100%;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="contenedor-app">
        <div class='imagen'></div>
        <div class="app">
             <?php echo $contenido; ?>
        </div>
    </div>
    
<?php
    echo $script?? '';
?>
                <div id="map"></div>

    <!-- Footer -->
    <footer>
        <p>Tu información de contacto u otros detalles aquí.</p>
    </footer>

 
</body>
</html>