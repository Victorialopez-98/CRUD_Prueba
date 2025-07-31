<?php
// MOSTRAR ERRORES
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CONEXIÓN Y FUNCIONES
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/models/ventas.php';

$venta_guardada = null;
$errores = [];
$id_clientes = '';
$fecha = '';

// Obtener lista de clientes desde la base de datos
$clientes = obtenerClientes();

// Manejar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_clientes = trim($_POST['id_clientes'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');

    if ($id_clientes === '' || $fecha === '') {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (empty($errores)) {
        $fecha_formateada = date('Y-m-d H:i:s', strtotime($fecha));
        $nombre_cliente = obtenerNombreClientePorId($id_clientes);

        if (insertarVenta($id_clientes, $fecha_formateada)) {
            $venta_guardada = [
                'cliente' => $nombre_cliente,
                'fecha' => $fecha_formateada
            ];
            // Limpiar campos del formulario
            $id_clientes = '';
            $fecha = '';
        } else {
            $errores[] = "Error al insertar la venta.";
        }
    }
}

// Si no se envió el formulario, establecer la fecha actual por defecto
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $fecha = date('Y-m-d\TH:i');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
    <link rel="stylesheet" href="/crudControlEmpresa/css/style.css">
    <header style="background-color: #222; padding: 15px;">
        <nav style="display: flex; justify-content: center; gap: 25px;">
            <a href="index.php" style="color: #fff; text-decoration: none;">Inicio</a>
            <a href="crud/insertarClientes.php" style="color: #fff; text-decoration: none;">Clientes</a>
            <a href="insertarventa.php" style="color: #fff; text-decoration: none;">Ventas</a>
        </nav>
    </header>
</head>
<body>
    

    <h1>Registrar Nueva Venta</h1>

    <?php if (!empty($errores)): ?>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li style="color:red;"><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="" class="formulario-cliente">
        <label>Cliente:</label>
        <select name="id_clientes" required>
            <option value="">Seleccione</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['id_clientes'] ?>" <?= ($id_clientes == $cliente['id_clientes']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cliente['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Fecha:</label>
        <input type="datetime-local" name="fecha" value="<?= htmlspecialchars($fecha) ?>" required>

        <button type="submit">Guardar Venta</button>
    </form>

    <?php if ($venta_guardada): ?>
        <section class="tarjeta">
            <h3>Venta registrada</h3>
            <p><strong>Cliente:</strong> <?= htmlspecialchars($venta_guardada['cliente']) ?></p>
            <p><strong>Fecha:</strong> <?= htmlspecialchars($venta_guardada['fecha']) ?></p>
        </section>
    <?php endif; ?>
</body>
</html>
