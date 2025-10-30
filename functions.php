<?php

# FUNCIÓN DE DEBUGEO
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

define("CONSTANTE", 7);

# LÓGICA DE NEGOCIO 
function leerArchivoCSV($rutaArchivoCSV) {
    $tabla = [];
    $header = [];

    if (($puntero = fopen($rutaArchivoCSV, "r")) !== FALSE) {
        $header = fgetcsv($puntero);
        while (($datosFila = fgetcsv($puntero)) !== FALSE) {
            $tabla[] = $datosFila;
        }
        fclose($puntero);
    }

    return [
        0 => array('header' => $header),
        1 => array('datos' => $tabla)
    ];
}

function mostrarUsuarios($rutaCSV){
    $output = "<div class='container'>"; 
    $output .= "<table class='responsive-table'>";

    $output .= "<tr>";
    // foreach ($rutaCSV[0]["header"] as $header){
    //     $output .= "<th>${header}</th>"; 
    // }

    // CABECERA
    $header = $rutaCSV[0]["header"];
    $output .= "<td>$header[1]</td>";
    $output .= "<td>$header[2]</td>";
    $output .= "<td>$header[3]</td>";
    $output .= "<th>Acciones</th>";
    $output .= "</tr>";

    // DATOS
    $dato = $rutaCSV[1]["datos"];



    foreach($rutaCSV[1]["datos"] as $fila){
        $output .= "<tr>";
        $output .= "<td>$fila[1]</td>";
        $output .= "<td>$fila[2]</td>";
        $output .= "<td>$fila[3]</td>";
        // foreach($fila as $dato){
           
        // }

        //  Formulario que llama a delete_users.php
        $output .= "<td>
            <form method='POST' action='delete_users.php'>
                <input type='hidden' name='id_borrar' value='{$fila[0]}'>
                <button type='submit' name='eliminar'>Eliminar</button>
            </form>
        </td>";

        //  Formulario que abre el javascript ubicado en el show_users.php
        $output .= "<td>
                <form method='POST' action='show_users.php'>
                <input type='hidden' name='id_mostrarMas' value='{$fila[0]}'>
                <button type='submit' name='mostrarMas'>Mostrar Más</button>
            </form>
        </td>";
        $output .= "</tr>";
    }

    $output .= "</table>";
    $output .= "</div>";
    return $output;
}


function mostrarMas($rutaCSV, $id_mostrarMas){
    $output = "<div class='detalleUsuario'>";

    foreach($rutaCSV[1]["datos"] as $fila){
        if ($fila[0] == $id_mostrarMas){
            $header = $rutaCSV[0]["header"];

            $output .= "<div class='foto_User'>";
            $output .= "<h1>Imagen</h1>"; // Aquí podrías añadir una imagen si tienes la ruta
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
