<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
//trayendo datos de la tabla faltas
$query = $con->query("SELECT faltas.idFalta, faltas.fecha, faltas.idPersonal, faltas.idTipoFalta, faltas.observaciones, personal.nombres, personal.primApellido, personal.segApellido FROM faltas inner join personal on faltas.idPersonal = personal.idPersonal");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/scripts.php' ?>
    <title>Listado de faltas y retardos</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <br>
        <h1>Listado de Faltas y Retardos</h1>
        <br>
        <!-- inicia Tabla -->
        <table id="tbFaltas">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Empleado</th>
                    <th>Fecha</th>
                    <th>Tipo de falta</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $data) : ?>
                    <tr>

                        <td><?php echo $data['idFalta'] ?></td>
                        <td><?php echo $data['nombres'] ?> <?php echo $data['primApellido'] ?> <?php echo $data['segApellido'] ?></td>
                        <td><?php echo $data['fecha'] ?></td>
                        <?php if ($data['idTipoFalta'] == 1) {
                            $tipoFalta = "Falta";
                        } else {
                            $tipoFalta = "Retardo";
                        }
                        ?>
                        <td><?php echo $tipoFalta ?></td>
                        <td><?php echo $data['observaciones'] ?></td>
                        <td>
                            <a class="add" href="editarFalta.php?id=<?php echo $data['idFalta'] ?>"><i class="fa-solid fa-users-slash fa-2x"></i>Editar</a>
                            |
                            <a class="delete" href="eliminarFalta.php?id=<?php echo $data['idFalta'] ?>"><i class="fa-solid fa-users-slash fa-2x"></i>Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <?php include 'includes/footer.php' ?>
    <script>
        var tabla = new DataTable("#tbFaltas", {
            searchable: true,
            sortable: false,
            fixedHeight: true,
            perPage: 10,
            perPageSelect: [10, 20, 30, 40, 50],
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