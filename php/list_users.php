<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $paymentStatus = $_POST['payment_status'];
    $sql = "UPDATE users SET payment_status='$paymentStatus' WHERE id='$userId'";
    $conn->query($sql);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<form method='post' action=''>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Cédula de Identidad</th>
                    <th>Nombre de Local/Empresa</th>
                    <th>Nombre y Apellido</th>
                    <th>Teléfono</th>
                    <th>Categoría</th>
                    <th>Comentarios de Categoría</th>
                    <th>Estado de Pago</th>
                    <th>Acciones</th>
                </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["id_card"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["surname"]."</td>
                <td>".$row["phone"]."</td>
                <td>".$row["category"]."</td>
                <td>".$row["category_comment"]."</td>
                <td>
                    <select name='payment_status' onchange='this.form.submit()'>
                        <option value='Pagado'".($row['payment_status'] == 'Pagado' ? ' selected' : '').">Pagado</option>
                        <option value='No Pagado'".($row['payment_status'] == 'No Pagado' ? ' selected' : '').">No Pagado</option>
                    </select>
                    <input type='hidden' name='user_id' value='".$row['id']."'>
                </td>
                <td>
                    <a href='edit_user.php?id=".$row['id']."'><button type='button'>Editar</button></a>
                    <a href='delete_user.php?id=".$row['id']."' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este usuario?');\"><button type='button'>Eliminar</button></a>
                    <a href='export_pdf.php?id=".$row['id']."'><button type='button'>Imprimir</button></a>
                </td>
              </tr>";
    }
    echo "</table></form>";
} else {
    echo "0 resultados";
}
$conn->close();
?>

<a href="export_all_pdf.php"><button>Exportar Todos a PDF</button></a>
