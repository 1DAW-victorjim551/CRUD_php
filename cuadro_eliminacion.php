<?php
require_once "functions.php";

$id_borrar = $_POST['id_borrar'] ?? null;

if (!$id_borrar) {
    header("Location: user_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar eliminación</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #141E30, #243B55);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .confirm-box {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 320px;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-size: 20px;
            margin-bottom: 25px;
        }

        .btn {
            margin: 10px;
            padding: 10px 25px;
            font-size: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-yes {
            background: linear-gradient(45deg, #ff4b2b, #ff416c);
            box-shadow: 0 0 10px rgba(255, 65, 108, 0.5);
        }

        .btn-no {
            background: linear-gradient(45deg, #00b09b, #96c93d);
            box-shadow: 0 0 10px rgba(150, 201, 61, 0.5);
        }

        .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="confirm-box">
        <h2>¿Seguro que desea eliminar este usuario?</h2>

        <form method="POST" action="user_delete.php" style="display:inline;">
            <input type="hidden" name="id_borrar" value="<?php echo $id_borrar; ?>">
            <button type="submit" class="btn btn-yes">Sí</button>
        </form>

        <form method="POST" action="user_index.php" style="display:inline;">
            <button type="submit" class="btn btn-no">No</button>
        </form>
    </div>
</body>
</html>
