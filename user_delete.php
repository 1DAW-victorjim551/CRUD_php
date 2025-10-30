<?php
global $rutaCSV; 
$ruta_CSV = "./usuarios.csv";
function borrarUsuario($id_borrar, $ruta_CSV) {
    $usuarios = [];

    // Leer CSV
    if (($handle = fopen($ruta_CSV, "r")) !== FALSE) {
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
    if (($handle = fopen($ruta_CSV, "w")) !== FALSE) {
        foreach ($usuarios as $usuario) {
            fputcsv($handle, $usuario);
        }
        fclose($handle);
    }
}

// Si se envía el formulario desde show_users.php
if (isset($_POST['eliminar']) && isset($_POST['id_borrar'])) {
    borrarUsuario($_POST['id_borrar'], $ruta_CSV);
}


header("Location: user_index.php");
exit;
?>
