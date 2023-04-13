<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$querry = $con->prepare("SELECT * From grupo inner join seccion s on grupo.idSeccion = s.idSeccion");
$querry->execute();
$ejecutar = $querry->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Grupo | Lista</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de Grupos</h1>




        <table id="tbAlumnos">
            <thead>
                <tr>

                    <th>Grupo</th>
                    <th>Sección</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($ejecutar as $data) : ?>
                    <tr>
                        <td><?php echo $data['grupo'] ?></td>
                        <td><?php echo $data['seccion'] ?></td>
                        <td>
                            <a class="edit" href="editarGrupo.php?id=<?php echo  $data['idGrupo'] ?>"><i class="fa-solid fa-users-rectangle fa-2x"> </i> EDITAR</a>
                            |
                            <a class="delete" href="confimarEliminarGrupo.php?id=<?php echo $data['idGrupo'] ?>"><i class="fa-solid fa-2x fa-users-rays"></i> BORRAR</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <script>
        var tabla = new DataTable("#tbAlumnos", {
            searchable: true,
            fixedHeight: true,
            fixedColumns: true,
            sortable: false,
            perPage: 5,
            perPageSelect: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });
    </script>


    <?php include "includes/footer.php"; ?>
</body>

</html>