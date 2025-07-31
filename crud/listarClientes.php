<?php
require_once(__DIR__ . '/../models/clientes.php');
require_once(__DIR__ . '/../config/conexion.php');

$modelo = new ClienteModel($pdo);
$clientes = $modelo->obtenerClientes();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="/crudControlEmpresa/css/style.css">
    <!-- Cargar DataTables y jQuery desde CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#tablaClientes').DataTable();
    });
    </script>
    <header style="background-color: #222; padding: 15px;">
        <nav style="display: flex; justify-content: center; gap: 25px;">
            <a href="../index.php" style="color: #fff; text-decoration: none;">Inicio</a>
            <a href="../crud/insertarClientes.php" style="color: #fff; text-decoration: none;">Clientes</a>
            <a href="../insertarventa.php" style="color: #fff; text-decoration: none;">Ventas</a>
        </nav>
</header>
</head>
<body>
    <h1>Clientes Registrados</h1>

    <a href="insertarClientes.php">Cliente nuevo</a>
    <br><br>

    <table id="tablaClientes" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['id_clientes']) ?></td>
                    <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                    <td>
                        <a href="editarClientes.php?id=<?= $cliente['id_clientes'] ?>" class="btn-editar">Editar</a> |
                        <a href="eliminarClientes.php?id=<?= $cliente['id_clientes'] ?>" class="btn-eliminar " onclick="return confirm('¿Estas seguro que deseas eliminar este cliente?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
    const filas = document.querySelectorAll("table.dataTable tbody tr");
    filas.forEach((fila, i) => {
        fila.style.opacity = 0;
        fila.style.transform = "translateY(10px)";
        fila.style.transition = "all 0.4s ease";
        setTimeout(() => {
            fila.style.opacity = 1;
            fila.style.transform = "translateY(0)";
        }, 100 * i); // escalonado
    });
});
</script>
</body>
</html>
