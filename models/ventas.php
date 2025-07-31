<?php
require_once __DIR__ . '/../config/conexion.php';

function insertarVenta($id_clientes, $fecha) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO ventas (id_clientes, fecha) VALUES (:id_clientes, :fecha)");
    $stmt->bindParam(':id_clientes', $id_clientes, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha);
    return $stmt->execute();
}

function obtenerClientes() {
    global $pdo;
    $stmt = $pdo->query("SELECT id_clientes, nombre FROM clientes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerNombreClientePorId($id_clientes) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nombre FROM clientes WHERE id_clientes = :id");
    $stmt->bindParam(':id', $id_clientes, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch();
    return $resultado ? $resultado['nombre'] : 'Desconocido';
}
?>
