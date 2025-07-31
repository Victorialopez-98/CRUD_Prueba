<?php
require_once(__DIR__ . '/../models/clientes.php');
require_once(__DIR__ . '/../config/conexion.php');

$modelo = new ClienteModel($pdo);


$errores = [];
$nombre = $email = $telefono = '';

// validacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    // Validación básica
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Correo inválido.";
    }
    if (!preg_match('/^\d{7,15}$/', $telefono)) {
        $errores[] = "Teléfono inválido. Solo números, de 7 a 15 dígitos.";
    }

    // Si no hay errores, insertar
    if (empty($errores)) {
        if ($modelo->insertarCliente($nombre, $email, $telefono)) {
            header("Location: listarClientes.php");
            exit;
        } else {
            $errores[] = "Error al insertar el cliente.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insertar Cliente</title>
    <link rel="stylesheet" href="/crudControlEmpresa/css/style.css">
    <header style="background-color: #222; padding: 15px;">
        <nav style="display: flex; justify-content: center; gap: 25px;">
            <a href="../index.php" style="color: #fff; text-decoration: none;">Inicio</a>
            <a href="../crud/insertarClientes.php" style="color: #fff; text-decoration: none;">Clientes</a>
            <a href="../insertarventa.php" style="color: #fff; text-decoration: none;">Ventas</a>
        </nav>
</header>
</head>

<body>
    <h1>Registrar Nuevo Cliente</h1>

    <?php if ($errores): ?>
        <ul style="color:red;">
            <?php foreach ($errores as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action=""  class="formulario-cliente">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($telefono) ?>"><br><br>

        <button type="submit">Guardar</button>
    </form>

    <br>
    <a href="listarClientes.php" class="boton-volver">Volver al listado</a>

    <script>
document.querySelector("form").addEventListener("submit", function(e) {
    const nombre = document.getElementById("nombre").value.trim();
    const email = document.getElementById("email").value.trim();
    const telefono = document.getElementById("telefono").value.trim();

    let errores = [];

    if (nombre === "") errores.push("El nombre es obligatorio.");
    if (email === "" || !email.includes("@")) errores.push("Email inválido.");
    if (telefono === "" || isNaN(telefono)) errores.push("Teléfono inválido.");

    if (errores.length > 0) {
        e.preventDefault();
        alert(errores.join("\n"));
    }
});
</script>
</body>
</html>
