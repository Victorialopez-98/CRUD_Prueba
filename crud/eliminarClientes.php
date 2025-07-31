<?php
require_once(__DIR__ . '/../models/clientes.php');
require_once(__DIR__ . '/../config/conexion.php');;

$modelo = new ClienteModel($pdo);

// Validar que llegue el id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de cliente inválido.");
}

$id_clientes = (int) $_GET['id'];

// Verificar si existe antes de eliminar
$cliente = $modelo->obtenerClientePorId($id_clientes);
if (!$cliente) {
    die("Cliente no encontrado.");
}

// Eliminar
$exito = $modelo->eliminarCliente($id_clientes);
if ($exito) {
    header("Location: listarClientes.php");
    exit;
} else {
    echo "Error al eliminar el cliente.";
}
?>
