<?php
include 'connection.php';

$id_card = $_POST['id_card'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$phone = $_POST['phone'];
$category = $_POST['category'];
$category_comment = isset($_POST['category_comment']) ? $_POST['category_comment'] : '';

// Verificar si el email ya existe
$sql_check = "SELECT * FROM users WHERE id_card='$id_card'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "Error: El usuario con esta cédula de identidad ya está registrado.";
} else {
    // Insertar el nuevo usuario
    $sql = "INSERT INTO users (id_card, name, surname, phone, category, category_comment) 
            VALUES ('$id_card', '$name', '$surname', '$phone', '$category', '$category_comment')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
