<?php
require_once 'models/productos.php';
require_once 'config/conexion.php';

$modelo = new ProductoModel($pdo);

$errores = [];
$nombre = $precio = $categoria = '';
$producto_guardado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $precio = trim($_POST['precio']);
    $categoria = trim($_POST['categoria']);

    // Validaciones
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (!is_numeric($precio) || $precio <= 0) $errores[] = "Precio inválido.";
    if (empty($categoria)) $errores[] = "La categoría es obligatoria.";

    if (empty($errores)) {
        if ($modelo->insertarProducto($nombre, $precio, $categoria)) {
            $producto_guardado = true;
        } else {
            $errores[] = "Error al guardar el producto.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/crudControlEmpresa/css/style.css">
    <title>Registrar Producto</title>
    <header style="background-color: #222; padding: 15px;">
        <nav style="display: flex; justify-content: center; gap: 25px;">
            <a href="index.php" style="color: #fff; text-decoration: none;">Inicio</a>
            <a href="crud/insertarClientes.php" style="color: #fff; text-decoration: none;">Clientes</a>
            <a href="insertarventa.php" style="color: #fff; text-decoration: none;">Ventas</a>
        </nav>
    </header>
</head>
<body>

    <main>
        <h1>Registrar Producto</h1>

        <?php if ($errores): ?>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-control">
                <label for="nombre">Nombre del producto:</label>
                <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>">
            </div>

            <div class="form-control">
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" step="0.01" value="<?= htmlspecialchars($precio) ?>">
            </div>

            <div class="form-control">
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria">
                    <option value="">Seleccione</option>
                    <option value="Tecnología" <?= $categoria === 'Tecnología' ? 'selected' : '' ?>>Tecnología</option>
                    <option value="Ropa" <?= $categoria === 'Ropa' ? 'selected' : '' ?>>Ropa</option>
                    <option value="Comida" <?= $categoria === 'Comida' ? 'selected' : '' ?>>Comida</option>
                    <option value="Otros" <?= $categoria === 'Otros' ? 'selected' : '' ?>>Otros</option>
                </select>
            </div>

            <button type="submit">Guardar Producto</button>
        </form>

        <?php if ($producto_guardado): ?>
            <section class="tarjeta">
                <h2><?= htmlspecialchars($nombre) ?></h2>
                <p><strong>Precio:</strong> $<?= number_format($precio, 2) ?></p>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($categoria) ?></p>
            </section>
        <?php endif; ?>
    </main>


    <script>
document.querySelector("form").addEventListener("submit", function (e) {
    const nombre = document.getElementById("nombre").value.trim();
    const precio = document.getElementById("precio").value.trim();
    const categoria = document.getElementById("categoria").value;

    let errores = [];

    if (nombre === "") errores.push("El nombre del producto es obligatorio.");
    if (precio === "" || isNaN(precio) || parseFloat(precio) <= 0) errores.push("Precio inválido.");
    if (categoria === "") errores.push("Debe seleccionar una categoría.");

    if (errores.length > 0) {
        e.preventDefault();
        alert(errores.join("\n"));
    }
});
</script>
</body>
</html>
