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
    $output .= "<th>$header[1]</th>";
    $output .= "<th>$header[2]</th>";
    $output .= "<th>$header[3]</th>";
    $output .= "<th colspan='3'>Acciones</th>";
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
            <form method='POST' action='user_delete.php'>
                <input type='hidden' name='id_borrar' value='$fila[0]'>
                <button type='submit' name='eliminar'>Eliminar</button>
            </form>
        </td>";

        //  Formulario que abre el javascript ubicado en el show_users.php
        $output .= "<td>
            <button class='btnMostrarMas' data-id='$fila[0]'>Mostrar Más</button>
        </td>";

        $output .= "<td>
            <form method='GET' action='user_edit.php'>
                <input type='hidden' name='id_edit' value='$fila[0]'>
                <button type='submit' name='editar'>Editar</button>
            </form>
        </td>";

        $output .= "</tr>";
    }

    $output .= "</table>";
    $output .= "</div>";
    return $output;
}

?>
