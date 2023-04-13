<?php
require '../conexion.php';
session_start();
$conn = new Database();
$con = $conn->conectar();
$querry = $con->prepare("SELECT * FROM oficios");
$querry->execute();
$datos = $querry->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../sistema/includes/scripts.php"; ?>
    <title>Oficios Elaborados</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de Oficios elaborados</h1>
        <br>
        <table id="tbOficios">
            <thead>
                <tr>
                    <th>Id Oficio</th>
                    <th>Asunto</th>
                    <th>Destinatario</th>
                    <th>Fecha de elaboración</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos as $data) : ?>

                    <tr>
                        <td><?php echo $data['idOficio'] ?></td>
                        <td><?php echo $data['asunto'] ?></td>
                        <td><?php echo $data['destinatario'] ?></td>
                        <td><?php echo $data['fecha'] ?></td>
                        <td>
                            <a class="edit" href="editarOficio.php?id=<?php echo  $data['idOficio'] ?>"><i class="fa-solid fa-file-signature fa-2x" style="color: #1ce329;"></i> EDITAR</a>

                            |

                            <a class="delete" href="eliminarOficio.php?id=<?php echo $data['idOficio'] ?>"><i class="fa-solid fa-2x fa-file-circle-xmark "></i> BORRAR</a>

                            |

                            <a class="add" href="../sistema/Formas/reportePdf.php?id=<?php echo $data['idOficio'] ?>"><i class="fa-solid fa-print fa-2x"></i> Imprimir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <script>
        var tabla = new DataTable("#tbOficios", {
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