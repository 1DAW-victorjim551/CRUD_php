<?php

function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

	function escribirCSV($nombreArchivo, $datos) {
    // Abrir el archivo en modo escritura (crea el archivo si no existe)
    $archivo = fopen($nombreArchivo, 'a');

    if ($archivo === false) {
        die("No se pudo abrir el archivo para escritura.");
    }

    // Recorrer los datos y escribir cada fila como línea CSV	
        fputcsv($archivo, $datos);

    // Cerrar el archivo
    fclose($archivo);
}

global $id;
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	$id += 1;
	$nombreUsuario = $_POST["txt"];
	$email = $_POST["email"];
	$rol = $_POST["rol"]??'Visitante';
	$paswd = $_POST["pswd"];
	$date = date("d/m/Y");
	
	$datos = [$id, $nombreUsuario, $email, $rol, $paswd, $date];
	dump($datos);
	escribirCSV("./login.csv", $datos);
}

	
?>


<!DOCTYPE html>
<html>
<head>
	<title>Slide Navbar</title>
	<link rel="stylesheet" type="text/css" href="./index.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="txt" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
        <select id="rol" name="rol" required="">
            <option value="Admin">Admin</option>
            <option value="Editor">Editor</option>
            <option value="Visitante">Visitante</option>
        </select>
		<input type="file" name="imagen_a_subir" accept="image/*">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button type='submit'>Sign up</button>
				</form>
			</div>

			<div class="login">
				<form>
					<label for="chk" aria-hidden="true">Login</label>
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button>Login</button>
				</form>
			</div>
	</div>
<br><br><br><br><br><br><br><br><br>
	<a href="show_users.php">Mostrar Usuarios</a>
</body>
</html>