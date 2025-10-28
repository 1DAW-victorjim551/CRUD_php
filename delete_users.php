<?php
$rutaCSV = "./login.csv";
function borrarUsuario($id_borrar, $ruta_csv) {
    $usuarios = [];

    // Leer CSV
    if (($handle = fopen($ruta_csv, "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            $usuarios[] = $data;
        }
        fclose($handle);
    }

    // Buscar y eliminar
    foreach ($usuarios as $i => $usuario) {
        if ($i == 0) continue; // saltar encabezado
        if ($usuario[0] == $id_borrar) {
            unset($usuarios[$i]);
            break;
        }
    }

    // Reescribir CSV
    if (($handle = fopen($ruta_csv, "w")) !== FALSE) {
        foreach ($usuarios as $usuario) {
            fputcsv($handle, $usuario);
        }
        fclose($handle);
    }
}

// Si se envía el formulario desde show_users.php
if (isset($_POST['eliminar']) && isset($_POST['id_borrar'])) {
    borrarUsuario($_POST['id_borrar'], $ruta_csv);
}


header("Location: show_users.php");
exit;
?>
