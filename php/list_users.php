<?php
include 'connection.php';

// Manejar la actualización del estado de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $paymentStatus = $_POST['payment_status'];
    $sql = "UPDATE users SET payment_status='$paymentStatus' WHERE id='$userId'";
    $conn->query($sql);
}

// Obtener la lista de usuarios
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Dashboard de Administración</h1>
    </header>
    <main>
        <h2>Lista de Usuarios</h2>
        <a href="export_all_pdf.php"><button class="export-button">Exportar Todos a PDF</button></a>';

if ($result->num_rows > 0) {
    echo '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CI</th>
                    <th>Nombre de Local/Empresa</th>
                    <th>Nombre y Apellido</th>
                    <th>Teléfono</th>
                    <th>Categoría</th>
                    <th>Comentarios</th>
                    <th>Estado de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row["id"] . '</td>
                <td>' . $row["id_card"] . '</td>
                <td>' . $row["name"] . '</td>
                <td>' . $row["surname"] . '</td>
                <td>' . $row["phone"] . '</td>
                <td>' . $row["category"] . '</td>
                <td>' . $row["category_comment"] . '</td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="' . $row['id'] . '">
                        <select name="payment_status" onchange="this.form.submit()">
                            <option value="Pagado"' . ($row['payment_status'] == 'Pagado' ? ' selected' : '') . '>Pagado</option>
                            <option value="No Pagado"' . ($row['payment_status'] == 'No Pagado' ? ' selected' : '') . '>No Pagado</option>
                        </select>
                    </form>
                </td>
                <td class="action-buttons">
                    <a href="edit_user.php?id=' . $row['id'] . '"><button type="button">Editar</button></a>
                    <a href="delete_user.php?id=' . $row['id'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este usuario?\');"><button type="button">Eliminar</button></a>
                    <a href="export_pdf.php?id=' . $row['id'] . '"><button type="button">Imprimir</button></a>
                </td>
            </tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No se encontraron usuarios registrados.</p>';
}

echo '</main></body></html>';

$conn->close();
?>
