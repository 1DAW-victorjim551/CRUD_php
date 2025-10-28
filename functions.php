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
    foreach ($rutaCSV[0]["header"] as $header){
        $output .= "<th>${header}</th>"; 
    }
    $output .= "<th>Acciones</th>";
    $output .= "</tr>";

    foreach($rutaCSV[1]["datos"] as $fila){
        $output .= "<tr>";
        foreach($fila as $dato){
            $output .= "<td>${dato}</td>";
        }

        // 🔹 Formulario que llama a delete_users.php
        $output .= "<td>
            <form method='POST' action='delete_users.php'>
                <input type='hidden' name='id_borrar' value='{$fila[0]}'>
                <button type='submit' name='eliminar'>Eliminar</button>
            </form>
        </td>";

        $output .= "</tr>";
    }

    $output .= "</table>";
    $output .= "</div>";
    return $output;
}

?>
