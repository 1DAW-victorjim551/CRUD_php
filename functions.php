<?php

# INICIALIZACIÓN DEL ENTORNO

#  FUNCIÓN DE DEBUGEO
    function dump($var){
        echo '<pre>'.print_r($var,1).'</pre>';
    }

    $archivo = fopen("divs_php.csv");

    # LÓGICA DE NEGOCIO 
   function leerArchivoCSV($rutaArchivoCSV) {
    $tablero = [];
    $header = [];

    if (($puntero = fopen($rutaArchivoCSV, "r")) !== FALSE) {
        $header = fgetcsv($puntero);
        while (($datosFila = fgetcsv($puntero)) !== FALSE) {
            $tablero[] = $datosFila;
        }
        fclose($puntero);
    }

    return [
        'header' => $header,
        'datos' => $tablero
    ];
}


    # LÓGICA DE PRESENTACIÓN

    $rutaCSV = leerArchivoCSV("./login.csv")

?>