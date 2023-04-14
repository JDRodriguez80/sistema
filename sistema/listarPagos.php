<?php
require '../conexion.php';
session_start();
$conn = new Database();
$con = $conn->conectar();
$querry = $con->prepare("SELECT * FROM pagos inner join alumnos on pagos.idAlumno = alumnos.idAlumno inner join tipoPago on pagos.idTipoPago = tipoPago.idTipoPago");
$querry->execute();
$datos = $querry->fetchAll(PDO::FETCH_ASSOC);
//trayendo datos del alumno


?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../sistema/includes/scripts.php"; ?>
    <title>Document</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Pagos Recibidos</h1>
        <br>
        <div class="form-Registro2">
            <table id="tbPagos">
                <thead>
                    <tr>
                        <th>Id Pago</th>
                        <th>Id Alumno</th>
                        <th>Fecha de pago</th>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($datos as $pagos) : ?>
                            <?php $nombreAlumno = $pagos['nombre'] . " " . $pagos['primApellido'] . " " . $pagos['segApellido'] ?>
                            <td><?php echo $pagos['idPago'] ?></td>
                            <td><?php echo $nombreAlumno ?></td>
                            <td><?php echo $pagos['fechaPago'] ?></td>
                            <td><?php echo $pagos['nombrePago'] ?></td>
                            <td><?php echo $pagos['abono'] ?></td>
                            <td>
                                <a href="editarPago.php?id=<?php echo $pagos['idPago'] ?>" class="add"><i class="fa-sharp fa-solid fa-money-bill-1-wave fa-2x"></i> Editar</a>
                                |
                                <a href="eliminarPago.php?id=<?php echo $pagos['idPago'] ?>" class="delete"><i class="fa-sharp fa-solid fa-money-bill-1-wave fa-2x"></i> Eliminar</a>
                                |
                                <a class="PDF" href="../sistema/Formas/ticketPdf.php?id=<?php echo $pagos['idPago'] ?>"><i class="fa-solid fa-print fa-2x"></i> Imprimir</a>
                            </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include 'includes/footer.php' ?>
    <script>
        var tabla = new DataTable("#tbPagos", {
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