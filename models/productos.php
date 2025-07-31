<?php

require_once __DIR__ . '/../config/conexion.php';

class ProductoModel {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertarProducto($nombre, $precio, $categoria) {
        $sql = "INSERT INTO productos (nombre, precio, categoria) VALUES (:nombre, :precio, :categoria)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':categoria', $categoria);
        return $stmt->execute();
    }
}
