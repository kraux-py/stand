<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin_login.html");
    exit();
}

include 'php/connection.php';

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

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Admin Dashboard </div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">No Disponible</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">No Disponible</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">No Disponible</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Usuario
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="php/logout.php">Cerrar Sesion</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid">
                <h1 class="mt-4">Dashboard de Administración</h1>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">New Visits</h4>
                                <p class="card-text">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">Messages</h4>
                                <p class="card-text">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">Purchases</h4>
                                <p class="card-text">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">Shoppings</h4>
                                <p class="card-text">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                <h2>Lista de Usuarios</h2>
                <a href="php/export_all_pdf.php"><button class="btn btn-success export-button">Exportar Todos a PDF</button></a>
                <div class="table-responsive">
                    <table class="table table-striped">
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
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
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
                                                <form method='post' action=''>
                                                    <input type='hidden' name='user_id' value='".$row['id']."'>
                                                    <select name='payment_status' onchange='this.form.submit()'>
                                                        <option value='Pagado'".($row['payment_status'] == 'Pagado' ? ' selected' : '').">Pagado</option>
                                                        <option value='No Pagado'".($row['payment_status'] == 'No Pagado' ? ' selected' : '').">No Pagado</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class='action-buttons'>
                                                <a href='php/edit_user.php?id=".$row['id']."'><button type='button' class='btn btn-primary btn-sm'>Editar</button></a>
                                                <a href='php/delete_user.php?id=".$row['id']."' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este usuario?');\"><button type='button' class='btn btn-danger btn-sm'>Eliminar</button></a>
                                                <a href='php/export_pdf.php?id=".$row['id']."'><button type='button' class='btn btn-secondary btn-sm'>Imprimir</button></a>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No se encontraron usuarios registrados.</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
</html>
