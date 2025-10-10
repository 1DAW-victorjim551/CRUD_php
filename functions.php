<?php
    function dump($var){
        echo '<pre>'.print_r($var,1).'</pre>';
    }

    $archivo = fopen("divs_php.csv");

    function leerArchivoCSV($rutaArchivoCSV) {
        $tablero = [];
    
        if (($puntero = fopen($rutaArchivoCSV, "r")) !== FALSE) {
            while (($datosFila = fgetcsv($puntero)) !== FALSE) {
                $tablero[] = $datosFila;
            }
            fclose($puntero);
        }
    
        return $tablero;
    }

?>