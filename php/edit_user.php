<?php
include 'connection.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_card = $_POST['id_card'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $category = $_POST['category'];
    $category_comment = isset($_POST['category_comment']) ? $_POST['category_comment'] : '';

    $sql = "UPDATE users SET 
            id_card='$id_card', 
            name='$name', 
            surname='$surname', 
            phone='$phone', 
            category='$category', 
            category_comment='$category_comment' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: list_users.php");
    } else {
        echo "Error actualizando el registro: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function showCategoryComment() {
            var category = document.getElementById("category").value;
            var commentBox = document.getElementById("category_comment");
            if (category === "Otros") {
                commentBox.style.display = "block";
            } else {
                commentBox.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Editar Usuario</h1>
    </header>
    <main>
        <form action="" method="post">
            <label for="id_card">Cédula de Identidad:</label>
            <input type="text" id="id_card" name="id_card" value="<?php echo $user['id_card']; ?>" required>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            <label for="surname">Apellido:</label>
            <input type="text" id="surname" name="surname" value="<?php echo $user['surname']; ?>" required>
            <label for="phone">Número de Teléfono:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
            <label for="category">Categoría:</label>
            <select id="category" name="category" onchange="showCategoryComment()" required>
                <option value="Gastronomía" <?php if($user['category'] == 'Gastronomía') echo 'selected'; ?>>Gastronomía</option>
                <option value="Venta" <?php if($user['category'] == 'Venta') echo 'selected'; ?>>Venta</option>
                <option value="Artesanía" <?php if($user['category'] == 'Artesanía') echo 'selected'; ?>>Artesanía</option>
                <option value="Juegos" <?php if($user['category'] == 'Juegos') echo 'selected'; ?>>Juegos</option>
                <option value="Tragos" <?php if($user['category'] == 'Tragos') echo 'selected'; ?>>Tragos</option>
                <option value="Empresarial" <?php if($user['category'] == 'Empresarial') echo 'selected'; ?>>Empresarial</option>
                <option value="Otros" <?php if($user['category'] == 'Otros') echo 'selected'; ?>>Otros</option>
            </select>
            <div id="category_comment" style="display: <?php echo ($user['category'] == 'Otros') ? 'block' : 'none'; ?>;">
                <label for="category_comment_text">Especificar Categoría:</label>
                <textarea id="category_comment_text" name="category_comment"><?php echo $user['category_comment']; ?></textarea>
            </div>
            <button type="submit">Actualizar</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Stand</p>
    </footer>
</body>
</html>
