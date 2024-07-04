<?php
include 'connection.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: list_users.php");
} else {
    echo "Error eliminando el registro: " . $conn->error;
}

$conn->close();
?>
