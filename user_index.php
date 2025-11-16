<?php 
include './functions.php';

// Leer CSV
$rutaCSV = leerArchivoCSV("usuarios.csv");
    // Leer CSV o BBDD
    $datos = obtenerUsuarios("bbdd");
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
    <?php echo mostrarUsuarios($datos); ?>

</body>
</html>
