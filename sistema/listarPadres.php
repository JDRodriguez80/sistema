<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$consulta = "SELECT * From padres inner join escolaridad e on padres.idEcolaridad = e.idEscolaridad";
$querry = $con->prepare($consulta);
$querry->execute();
$ejecutar = $querry->fetchAll();
?>

<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Padres | Lista</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de Padres</h1>




        <table id="tbPadres">


            <thead>
                <tr>

                    <th>Nombres</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Teléfono</th>
                    <th>Oficio</th>
                    <th>Curp</th>
                    <th>Escolaridad</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($ejecutar as $data) : ?>
                    <br>


                    <tr>

                        <td><?php echo $data['Nombres'] ?></td>
                        <td><?php echo $data['primApellido'] ?></td>
                        <td><?php echo $data['segApellido'] ?></td>
                        <td><?php echo $data['telefono'] ?></td>
                        <td><?php echo $data['oficio'] ?></td>
                        <td><?php echo $data['curp'] ?></td>
                        <td><?php echo $data['escolaridad'] ?></td>

                        <td>
                            <a class="edit" href="editarPadre.php?id=<?php echo  $data['idPadre'] ?>"><i class="fa-solid fa-user-pen fa-2x"> </i> EDITAR</a>
                            |
                            <a class="delete" href="eliminarPadre.php?id=<?php echo $data['idPadre'] ?>"><i class="fa-solid fa-2x fa-user-xmark"></i> BORRAR</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>



    <?php include "includes/footer.php"; ?>
    <script>
        var tabla = new DataTable("#tbPadres", {
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