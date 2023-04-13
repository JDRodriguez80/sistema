<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$query = "SELECT * From usuarios inner join nivelusuarios n on usuarios.nivelUsuario = n.idNivel";
$sql = $con->prepare($query);
$sql->execute();
$ejecutar = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Usuarios | Lista</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de Usuarios</h1>
        <div class="form-Registro2">
            <table id="tbUsuarios">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Nivel</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ejecutar as $data) : ?>
                        <tr>
                            <td><?php echo $data['usuario'] ?></td>
                            <td><?php echo $data['email'] ?></td>
                            <td><?php echo $data['nombreNivel'] ?></td>
                            <td>
                                <a class="edit" href="editarUsuario.php?id=<?php echo  $data['idUsuario'] ?>"><i class="fa-solid fa-users-rectangle fa-2x"> </i> EDITAR</a>
                                |
                                <a class="delete" href="eliminarUsuario.php?id=<?php echo $data['idUsuario'] ?>"><i class="fa-solid fa-2x fa-users-rays"></i> BORRAR</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>

    <!-- Script para datatables -->
    <script>
        var tabla = new DataTable("#tbUsuarios", {
            searchable: true,
            perPage: 5,
            fixedColumns: true,
            sortable: false,
            perPageSelect: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });
    </script>
</body>

</html>