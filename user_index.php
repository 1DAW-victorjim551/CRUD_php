<?php 
include './functions.php';

// Leer CSV
$rutaCSV = leerArchivoCSV("usuarios.csv");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>INDEX PHP</title>
<link rel="stylesheet" href="index_tabla.css">
</head>
<body>

    <!-- Tabla de usuarios -->
    <?php echo mostrarUsuarios($rutaCSV); ?>

    <!-- Modal de detalle del usuario -->
    <div class="image-container" id="imageContainer">
        <button class="close-btn" id="closeBtn">X</button>
        <div id="detalleUsuario"></div>
    </div>

    <script>
        const imageContainer = document.getElementById('imageContainer');
        const closeBtn = document.getElementById('closeBtn');
        const detalleUsuarioDiv = document.getElementById('detalleUsuario');

        // Cerrar modal al hacer click en X
        closeBtn.addEventListener('click', () => {
            imageContainer.classList.remove('show');
        });

        // Capturar click en todos los botones "Mostrar Más"
        document.querySelectorAll('.btnMostrarMas').forEach(btn => {
            btn.addEventListener('click', () => {
                const userId = btn.getAttribute('data-id');

                // Llamada básica a user_info.php
                fetch(`user_info.php?id=${userId}`)
                    .then(res => res.text())
                    .then(html => {
                        detalleUsuarioDiv.innerHTML = html;
                        imageContainer.classList.add('show'); // abrir modal con animación
                    });
            });
        });
    </script>

</body>
</html>
