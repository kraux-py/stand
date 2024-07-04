<?php
include 'connection.php';

$username = 'admin';
$password = 'muniayolas2024';  // Cambia esta contraseña por una más segura
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE admins SET password='$hashed_password' WHERE username='$username'";

if ($conn->query($sql) === TRUE) {
    echo "Contraseña actualizada exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
