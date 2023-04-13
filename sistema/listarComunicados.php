<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$querry = $con->prepare("SELECT * FROM `comunicados`");
$querry->execute();
$result = $querry->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include "includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de comunicados</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de comunicados</h1>
        <br>
        <table id="tblComunicados">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$result) {
                    echo "<tr><td>No hay comunicados</td></tr>";
                } else {
                    foreach ($result as $row) { ?>
                        <tr>
                            <td><?php echo $row['fecha'] ?></td>
                            <td><?php echo $row['nombreComunicado'] ?></td>
                            <td><?php echo $row['tipo'] ?></td>
                            <td>
                                <a class="edit" href="editarComunicado.php?id=<?php echo   $row['idComunicado'] ?>"><i class="fa-solid fa-comment fa-2x"> </i> EDITAR</a>
                                |
                                <a class="delete" href="eliminarComunicado.php?id=<?php echo $row['idComunicado'] ?>"><i class="fa-solid fa-2x fa-comment-slash"></i> BORRAR</a>

                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </section>
    <?php include 'includes/footer.php' ?>
    <script>
        var tabla = new DataTable("#tblComunicados", {
            searchable: true,
            sortable: false,
            fixedHeight: true,
            perPage: 5,
            perPageSelect: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros ({pages} páginas)"
            }
        });
    </script>

</body>

</html>