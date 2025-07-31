<?php
require_once(__DIR__ . '/../models/clientes.php');
require_once(__DIR__ . '/../config/conexion.php');

$modelo = new ClienteModel($pdo);

$errores = [];
$cliente = null;

// Validar dellegada de id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Id del cliente inválido.");
}

$id_clientes = (int) $_GET['id'];

// Obtener datos del cliente
$cliente = $modelo->obtenerClientePorId($id_clientes);
if (!$cliente) {
    die("Cliente no encontrado.");
}

// Si envía el form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    // Validaciones
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }
    if (!preg_match('/^\d{7,15}$/', $telefono)) {
        $errores[] = "El teléfono debe tener entre 7 y 15 dígitos numéricos.";
    }

    // Si no hay errores, actualizar
    if (empty($errores)) {
        $exito = $modelo->editarCliente($id_clientes, $nombre, $email, $telefono);
        if ($exito) {
            header("Location: listarClientes.php");
            exit;
        } else {
            $errores[] = "Error al actualizar el cliente.";
        }
    }
} else {
    // Si no envió formulario, llenar los valores con los datos actuales
    $nombre = $cliente['nombre'];
    $email = $cliente['email'];
    $telefono = $cliente['telefono'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/crudControlEmpresa/css/style.css" class="formulario-cliente">
    <title>Editar Cliente</title>
    <header style="background-color: #222; padding: 15px;">
        <nav style="display: flex; justify-content: center; gap: 25px;">
            <a href="../index.php" style="color: #fff; text-decoration: none;">Inicio</a>
            <a href="/crud/insertarClientes.php" style="color: #fff; text-decoration: none;">Clientes</a>
            <a href="../insertarventa.php" style="color: #fff; text-decoration: none;">Ventas</a>
        </nav>
    </header>
</head>
<body>
    <h1>Editar Cliente</h1>

    <?php if ($errores): ?>
        <ul style="color:red;">
            <?php foreach ($errores as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="" class="formulario-cliente">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($telefono) ?>"><br><br>

        <button type="submit">Actualizar</button>
    </form>

    <br>
    <a href="listarClientes.php" class="boton-volver">← Volver al listado</a>
</body>
</html>
