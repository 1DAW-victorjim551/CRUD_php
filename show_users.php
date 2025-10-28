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
</body>
</html>
