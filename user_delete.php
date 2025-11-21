<?php 
global $ruta_CSV; 
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

function borrarUsuarioBBDD($id_borrar){
    try {
        $conexionPDO = new PDO(
            'mysql:host=localhost;dbname=crud_mysql;charset=utf8',
            'crud_mysql',
            'crud_mysql'
        );
        $conexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'DELETE FROM usuarios WHERE ID = :ID';

        $stmt = $conexionPDO->prepare($sql);

        $stmt->bindValue(':ID', $id_borrar);

        $stmt->execute();
        
        $conexionPDO = null;
    } catch (PDOException $e) {
        die("Error al eliminar usuario: " . $e->getMessage());
    }
}

// Si se envía el formulario desde show_users.php
if (isset($_POST['eliminar']) && isset($_POST['id_borrar'])) {
    //BORRAR DESDE CSV
    // borrarUsuario($_POST['id_borrar'], $ruta_CSV);

    //BORRAR DESDE BASE DE DATOS
    $id_borrar = FILTER_INPUT() $_POST['id_borrar'];
    borrarUsuarioBBDD($id_borrar);
}

// Redirigir al índice
header("Location: user_index.php");
exit;
?>
