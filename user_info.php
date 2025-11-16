<?php
require_once "functions.php";

// Ruta del CSV
$rutaCSV = "usuarios.csv";

// Leemos el archivo
$usuarios = leerArchivoCSV($rutaCSV);

// Obtenemos el ID del usuario en concreto a mostrar desde POST
$id_mostrarMas = $_POST['id_mostrarmas'] ?? null;

// Función mostrarMas (del botón de Ver en user_index.php)
function mostrarMasCSV($rutaCSV, $id_mostrarMas){
    $output = "<div class='user'>";

    foreach($rutaCSV[1]["datos"] as $fila){
        if ($fila[0] == $id_mostrarMas){
            $header = $rutaCSV[0]["header"];

            // Imagen (falta por hacer la imágen)
            $output .= "<div class='image'>";
            $output .= "<h1>Imagen</h1>";
            $output .= "</div>";

            // Información del usuario
            $output .= "<div class='info'>";
            $output .= "<p class='name'><strong>{$header[1]}:</strong> {$fila[1]}</p>";
            for ($i = 0; $i < count($header); $i++) {
                if ($i != 1) {
                    $output .= "<p><strong>{$header[$i]}:</strong> {$fila[$i]}</p>";
                }
            }
            $output .= "</div>";
        }
    }

    $output .= "</div>";
    return $output;
}

    function dataFromBBDD(){

           try {
           $conexionPDO = new PDO(
        'mysql:host=localhost;dbname=crud_mysql;charset=utf8',
        'crud_mysql',
        'crud_mysql'
        );

    $sql = "SELECT * FROM usuarios";
    $stmt = $conexionPDO->prepare($sql);
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_NUM);
    $header = [];
    for ($i=0;$i<$stmt->columnCount();$i++){
        $meta = $stmt->getColumnMeta($i);
        $header[] = $meta['name'];
    }

    dump($datos);
    dump($header);

    return [
        0 => array('header' => $header),
        1 => array('datos' => $datos)
    ];
        } catch (PDOException $e) {
            die("Error al actualizar usuario: " . $e->getMessage());
        }
}

   function mostrarMasBBDD($id_mostrarMas, $datos){
    $output = "<div class='user'>";

    $header = $datos[0]['header'];
    $filas = $datos[1]['datos'];  

    foreach ($filas as $fila) {
        if ($fila[0] == $id_mostrarMas) {

            // Imagen (falta por poner imagen real)
            $output .= "<div class='image'>";
            $output .= "<h1>Imagen</h1>";
            $output .= "</div>";

            // Información del usuario
            $output .= "<div class='info'>";
            $output .= "<p class='name'><strong>{$header[1]}:</strong> {$fila[1]}</p>";

            for ($i = 0; $i < count($header); $i++) {
                if ($i != 1) {
                    $output .= "<p><strong>{$header[$i]}:</strong> {$fila[$i]}</p>";
                }
            }
            $output .= "</div>";
            break;
        }
    }

    $output .= "</div>";
    return $output;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de usuario</title>
    <link rel="stylesheet" href="user_info.css">

    <?php 
        $datos = dataFromBBDD();
    ?>
</head>
<body>
    <?php 
        if ($id_mostrarMas) {
            echo mostrarMasBBDD($id_mostrarMas, $datos);
        } else {
            echo "<p>No se ha especificado un usuario.</p>";
        }
    ?>
    <br>
    <form action="user_index.php" method="get">
        <button type="submit">Volver</button>
    </form>
</body>
</html>
