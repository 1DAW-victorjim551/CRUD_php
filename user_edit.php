<?php
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

// Función para reescribir un usuario en el CSV
function actualizarCSV($nombreArchivo, $idUsuario, $nuevosDatos) {
    $filas = [];

    if (($archivo = fopen($nombreArchivo, 'r')) !== false) {
        while (($datos = fgetcsv($archivo)) !== false) {
            $filas[] = $datos;
        }
        fclose($archivo);
    }

    foreach ($filas as $index => $fila) {
        if ($fila[0] == $idUsuario) {
            $filas[$index] = $nuevosDatos;
            break;
        }
    }

    if (($archivo = fopen($nombreArchivo, 'w')) !== false) {
        foreach ($filas as $fila) {
            fputcsv($archivo, $fila);
        }
        fclose($archivo);
    }
}

// Capturamos el ID del usuario desde GET
$idUsuario = $_GET['id_edit'] ?? null;
$usuarioCSV = "./usuarios.csv";

// Leer los usuarios del CSV usuarios
$usuarios = [];
if (($archivo = fopen($usuarioCSV, 'r')) !== false) {
    while (($datos = fgetcsv($archivo)) !== false) {
        $usuarios[] = $datos;
    }
    fclose($archivo);
}

// Buscar el  usuario concreto
$usuario = null;
foreach ($usuarios as $fila) {
    if ($fila[0] == $idUsuario) {
        $usuario = $fila;
        break;
    }
}

    function actualizarBBDD($nuevosDatos){
        try {
            $conexionPDO = new PDO(
                'mysql:host=localhost;dbname=crud_mysql;charset=utf8',
                'crud_mysql',
                'crud_mysql'
            );
            $conexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //$idUsuario, $nombreUsuario, $email, $rol, $paswd, $date, $fecha_mod
            $sql = 'UPDATE usuarios
                    SET USUARIO = :USUARIO,
                        EMAIL = :EMAIL,
                        ROL = :ROL,
                        PASSWORD = :PASSWORD,
                        DATE_MOD = :DATE_MOD
                    WHERE ID = :ID';

            $stmt = $conexionPDO->prepare($sql);

            $stmt->bindValue(':ID', $nuevosDatos[0]);
            $stmt->bindValue(':USUARIO', $nuevosDatos[1]);
            $stmt->bindValue(':EMAIL', $nuevosDatos[2]);
            $stmt->bindValue(':ROL', $nuevosDatos[3]);
            $stmt->bindValue(':PASSWORD', $nuevosDatos[4]);
            $stmt->bindValue(':DATE_MOD', $nuevosDatos[6]);
            dump($stmt);
            dump($nuevosDatos);
            
            $stmt->execute();
            $conexionPDO = null;
        } catch (PDOException $e) {
            dump($e);
            die("Error al actualizar usuario: " . $e->getMessage());
        }
    }
    dump("Aqui llega");
// Si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    dump("Aquí no");
    $nombreUsuario = $_POST["txt"];
    $email = $_POST["email"];
    $rol = $_POST["rol"] ?? 'Visitante';
    $paswd = $_POST["pswd"];
    $date = date("Y-m-d");
    $fecha_mod = date("Y-m-d"); // fecha_mod actual

    $nuevosDatos = [$idUsuario, $nombreUsuario, $email, $rol, $paswd, $date, $fecha_mod];

    //ACTUALIZAR MEDIANTE EL CSV
    // actualizarCSV($usuarioCSV, $idUsuario, $nuevosDatos);

    //ACTUALIZAR MEDIANTE BASE DE DATOS
    actualizarBBDD($nuevosDatos);
    header("Location: user_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
    <link rel="stylesheet" type="text/css" href="./index.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
<div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">

    <div class="signup">
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id_edit=' . $idUsuario; ?>" method="post">
            <label for="chk" aria-hidden="true">Editar Usuario</label>
            <input type="text" name="txt" placeholder="User name" required="" value="<?php echo $usuario[1] ?? ''; ?>">
            <input type="email" name="email" placeholder="Email" required="" value="<?php echo $usuario[2] ?? ''; ?>">
            <select id="rol" name="rol" required="">
                <option value="Admin" <?php if (($usuario[3] ?? '') == 'Admin') echo 'selected'; ?>>Admin</option>
                <option value="Editor" <?php if (($usuario[3] ?? '') == 'Editor') echo 'selected'; ?>>Editor</option>
                <option value="Visitante" <?php if (($usuario[3] ?? '') == 'Visitante') echo 'selected'; ?>>Visitante</option>
            </select>
            <input type="password" name="pswd" placeholder="Password" required="" value="<?php echo $usuario[4] ?? ''; ?>">
            <input type="file" name="imagen_a_subir" accept="image/*">
            <button type='submit'>Actualizar</button>
        </form>
    </div>
</div>

<div class="button-container">
    <a href="./user_index.php" class="button-link">Volver a Usuarios</a>
</div>

</body>
</html>
