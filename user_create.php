<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['pswd'];

    $conexionPDO = new PDO(
        'mysql:host=localhost;dbname=crud_mysql;charset=utf8',
        'crud_mysql',
        'crud_mysql'
    );

    $stmt = $conexionPDO->prepare("SELECT * FROM usuarios WHERE EMAIL = :email AND PASSWORD = :password");
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);


	
    if($usuario){
        $_SESSION['email'] = $usuario['EMAIL'];
        header("Location: ./user_index.php");
        exit;
    } else {
        echo "ERROR EN EL LOGIN";
    }
}

/*
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

function dump_StructureObject($Object){
    $r = new ReflectionClass(new $Object);
    echo '<pre>' . print_r($r->getProperties(), true) . '</pre>';
    echo '<pre>' . print_r($r->getMethods(), true) . '</pre>';
}

function dump_ValuesObjects($Object){
    $r = new ReflectionClass(new $Object);
    $arrayProperties[] =  $r->getProperties();
    $arrayMethods[] =  $r->getMethods();
    foreach ($arrayProperties as  $clave => $valor){
        echo '<pre>' . print_r($r->$valor, true) . '</pre>';
    }
    foreach ($arrayMethods as  $clave => $valor){
        echo '<pre>' . print_r($r->$valor, true) . '</pre>';
    }
}

class Person {
    public $name = 'Alex Super Tramp';
    public $age = 100;
    private $property = 'property';

    function miMetodo(){
        return true;
    }
}

$person = new Person();
// dump_StructureObject($person);
// dump_ValuesObjects($person);
*/

$servername = "localhost";
$username = "crud_mysql";
$password = "crud_mysql";

try {
    $conn = new PDO("mysql:host=$servername;dbname=crud_mysql", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function escribirCSV($nombreArchivo, $datos) {
    $archivo = fopen($nombreArchivo, 'a');
    if ($archivo === false) {
        die("No se pudo abrir el archivo para escritura.");
    }
    fputcsv($archivo, $datos);
    fclose($archivo);
}

function escribirBBDD($datos){
    $conexionPDO = new PDO(
        'mysql:host=localhost;dbname=crud_mysql;charset=utf8',
        'crud_mysql',
        'crud_mysql'
    );
    try {
        $smtd = $conexionPDO->prepare("INSERT INTO usuarios (ID, USUARIO, EMAIL, ROL, PASSWORD, DATE, DATE_MOD)
                        VALUES (:ID, :USUARIO, :EMAIL, :ROL, :PASSWORD, :DATE, :DATE_MOD)");

        $smtd->bindValue(':ID', $datos[0]);
        $smtd->bindValue(':USUARIO', $datos[1]);
        $smtd->bindValue(':EMAIL', $datos[2]);
        $smtd->bindValue(':ROL', $datos[3]);
        $smtd->bindValue(':PASSWORD', $datos[4]);
        $smtd->bindValue(':DATE', $datos[5]);
        $smtd->bindValue(':DATE_MOD', $datos[5]);

        $smtd->execute();
    } catch (\Throwable $th) {
        throw $th;
    }
}

global $id;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion']==="signup"){
    $id += 1;
    $nombreUsuario = $_POST["txt"];
    $email = $_POST["email"];
    $rol = $_POST["rol"]??'Visitante';
    $paswd = $_POST["pswd"];
    $date = date("Y-m-d");
    $fecha_mod = date("Y-m-d");

    $datos = [$id, $nombreUsuario, $email, $rol, $paswd, $date, $fecha_mod];
    // dump($datos);
    escribirBBDD($datos);
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
            <input type="text" name="txt" placeholder="User name" required>
            <input type="email" name="email" placeholder="Email" required>
            <select id="rol" name="rol" required>
                <option value="Admin">Admin</option>
                <option value="Editor">Editor</option>
                <option value="Visitante">Visitante</option>
            </select>
            <input type="password" name="pswd" placeholder="Password" required>
            <input type="hidden" name="accion" value="signup">
            <button type="submit">Sign up</button>
        </form>
    </div>

    <div class="login">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="chk" aria-hidden="true">Login</label>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="pswd" placeholder="Password" required>
            <input type="hidden" name="accion" value="login">
            <button type="submit">Login</button>
        </form>
        <?php if(isset($error_login)) echo "<p style='color:red;'>$error_login</p>"; ?>
    </div>
</div>

<div class="button-container">
    <a href="./user_index.php" class="button-link">Mostrar Usuarios</a>
</div>
</body>
</html>
