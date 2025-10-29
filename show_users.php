<?php 
    include './functions.php';
    $rutaCSV = leerArchivoCSV("login.csv");

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
    <?php echo mostrarUsuarios($rutaCSV); ?>

        <div class="image-container" id="imageContainer">
            <button class="close-btn" id="closeBtn">X</button>
            <img src="Media/1.png" alt="Imagen">
        </div>
    <script>
        // Obtener elementos para mi mapa web
        const showImageBtn = document.getElementById('showImageBtn');
        const imageContainer = document.getElementById('imageContainer');
        const closeBtn = document.getElementById('closeBtn');
    
        // Mostrar el contenedor de la imagen con efecto de zoom para desplegar el mapa web
        showImageBtn.addEventListener('click', () => {
          imageContainer.classList.add('show');
        });
    
        // Cierre de la ventana al darle click al botón de "X"
        closeBtn.addEventListener('click', () => {
          imageContainer.classList.remove('show');
        });
    </script>
</body>
</html>
