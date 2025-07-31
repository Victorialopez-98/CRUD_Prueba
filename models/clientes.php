<?php

require_once __DIR__ . '/../config/conexion.php';

class ClienteModel {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertarCliente($nombre, $email, $telefono) {
        $sql = "INSERT INTO clientes (nombre, email, telefono) VALUES (:nombre, :email, :telefono)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }

    public function obtenerClientes() {
        $stmt = $this->pdo->query("SELECT * FROM clientes ORDER BY id_clientes DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerClientePorId($id_clientes) {
        $sql = "SELECT * FROM clientes WHERE id_clientes = :id_clientes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_clientes', $id_clientes, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarCliente($id_clientes, $nombre, $email, $telefono) {
        $sql = "UPDATE clientes SET nombre = :nombre, email = :email, telefono = :telefono WHERE id_clientes = :id_clientes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_clientes', $id_clientes, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }

    public function eliminarCliente($id_clientes) {
        $sql = "DELETE FROM clientes WHERE id_clientes = :id_clientes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_clientes', $id_clientes, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
