<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';

//trayendo datos del acta
$querry = $con->prepare("SELECT laudatorias.idLaudatoria, laudatorias.fecha, laudatorias.motivo, laudatorias.idPersonal, personal.nombres, personal.primApellido, personal.segApellido FROM laudatorias inner join personal on laudatorias.idPersonal=personal.idPersonal");
$querry->execute();
$result = $querry->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/scripts.php' ?>
    <title>Actas Laudatorias</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <br>
        <h1>Actas laudatorias elaboradas</h1>
        <br>
        <table id="tbLaudatorias">
            <thead>
                <tr>
                    <th>Id Acta</th>
                    <th>Motivo</th>
                    <th>Destinatario</th>
                    <th>Fecha de elaboración</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($result as $row) : ?>
                        <td><?php echo $row['idLaudatoria'] ?></td>
                        <td><?php echo $row['motivo'] ?></td>
                        <td><?php echo $row['nombres'] ?> <?php echo $row['primApellido'] ?> <?php echo $row['segApellido'] ?></td>
                        <td><?php echo $row['fecha'] ?></td>
                        <td>
                            <a href="editarLaudatoria.php?id=<?php echo $row['idLaudatoria'] ?>" class="add"><i class="fa-sharp fa-solid fa-trophy fa-2x"></i>Editar</a>
                            |
                            <a href="eliminarLaudatoria.php?id=<?php echo $row['idLaudatoria'] ?>" class="delete"><i class="fa-sharp fa-solid fa-trophy fa-2x"></i>Eliminar</a>
                            |
                            <a class="PDF" href="../sistema/Formas/reporteLaudatoria.php?id=<?php echo $row['idLaudatoria'] ?>"><i class="fa-solid fa-print fa-2x"></i> Imprimir</a>
                        </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </section>
    <script>
        var tabla = new DataTable("#tbLaudatorias", {
            searchable: true,
            perPage: 5,
            fixedColumns: true,
            sortable: false,
            perPageSelect: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            labels: {
                placeholder: "Buscar Acta...",
                perPage: "{select} Actas por página",
                noRows: "No hay actas",
                info: "Mostrando {start} a {end} de {rows} actas ({pages} páginas)"
            }
        });
    </script>
</body>

</html>