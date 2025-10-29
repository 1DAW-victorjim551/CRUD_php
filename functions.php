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

        // 🔹 Formulario que llama a delete_users.php
        $output .= "<td>
            <form method='POST' action='delete_users.php'>
                <input type='hidden' name='id_borrar' value='{$fila[0]}'>
                <button type='submit' name='eliminar'>Eliminar</button>
            </form>
        ";

        $output .= "
            <form method='POST' action='show_more_users.php'>
                <input type='hidden' name='id_user' value='{$fila[0]}'>
                <button type='submit' name='mostrar_mas'>Mostrar más</button>
            </form>
        ";
        $output .= "</td>";
        $output .= "</tr>";
    }

    $output .= "</table>";
    $output .= "</div>";
    return $output;
}

?>
