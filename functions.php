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

# FUNCIONES DE BBDD (vacías, para implementar con PDO)
function leerDesdeBBDD() {
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
}


# FUNCIÓN ENVOLVENTE
function obtenerUsuarios($origen) {
    /*
      $origen: "csv" o "bbdd"
      Si es "csv" → $param1 = ruta del archivo
      Si es "bbdd" → $param1 = conexión PDO, $param2 = query SQL
    */
    if ($origen === "csv") {
        $rutaCSV = "./usuarios.csv" ;
        return leerArchivoCSV($rutaCSV);
    } elseif ($origen === "bbdd") {
        return leerDesdeBBDD();
    } else {
        return null;
    }
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
            <form method='POST' action='cuadro_eliminacion.php'>
                <input type='hidden' name='id_borrar' value='$fila[0]'>
                <button type='submit' name='eliminar'>Eliminar</button>
            </form>
        </td>";

        //  Formulario que abre el javascript ubicado en el show_users.php
        $output .= "<td>
            <form method='POST' action='user_info.php'>
                <input type='hidden' name='id_mostrarmas' value='$fila[0]'>
                <button type='submit' name='Ver'>Ver</button>
            </form>
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
