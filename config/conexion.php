<?php

$host = 'localhost';
$db = 'controlempresa';
$user = 'root'; 
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
