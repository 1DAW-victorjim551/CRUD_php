<?php
require_once "functions.php";

// Ruta del CSV
$rutaCSV = "usuarios.csv";

// Leemos el archivo
$usuarios = leerArchivoCSV($rutaCSV);

// Obtenemos el ID del usuario a mostrar desde POST o GET
$id_mostrarMas = $_GET['id'] ?? null;

if ($id_mostrarMas) {
    echo mostrarMas($usuarios, $id_mostrarMas);
} else {
    echo "<p>No se ha especificado un usuario.</p>";
}

// Función mostrarMas trasladada a este archivo
function mostrarMas($rutaCSV, $id_mostrarMas){
    $output = "<div class='detalleUsuario'>";

    foreach($rutaCSV[1]["datos"] as $fila){
        if ($fila[0] == $id_mostrarMas){
            $header = $rutaCSV[0]["header"];

            $output .= "<div class='foto_User'>";
            $output .= "<h1>Imagen</h1>";
            $output .= "</div>";

            $output .= "<div class='info_User'>";
            for ($i = 0; $i < count($header); $i++) {
                $output .= "<p><strong>{$header[$i]}:</strong> {$fila[$i]}</p>";
            }
            $output .= "</div>";
        }
    }

    $output .= "</div>";
    return $output;
}

?>
