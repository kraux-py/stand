<?php
include 'connection.php';

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=usuarios.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo "ID\tCédula de Identidad\tNombre\tApellido\tTeléfono\tDescripción\tCategoría\tComentarios de Categoría\n";

while($row = $result->fetch_assoc()) {
    echo $row['id'] . "\t" . $row['id_card'] . "\t" . $row['name'] . "\t" . $row['surname'] . "\t" . $row['phone'] . "\t" . $row['description'] . "\t" . $row['category'] . "\t" . $row['category_comment'] . "\n";
}

$conn->close();
?>
