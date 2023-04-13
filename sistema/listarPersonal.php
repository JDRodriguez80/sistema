<?php
require '../conexion.php';
session_start();
$conn = new Database();
$con = $conn->conectar();
//trayendo datos de la tabla personal
$querry = $con->prepare("SELECT * FROM personal ORDER BY curp ASC");
$querry->execute();
$personal = $querry->fetchAll(PDO::FETCH_ASSOC);
//trayendo datos de la tabla funcion
$querry = $con->prepare("SELECT * FROM funcion");
$querry->execute();
$funcion = $querry->fetchAll(PDO::FETCH_ASSOC);
//trayendo datos de la tabla sostenimiento
$querry = $con->prepare("SELECT * FROM sostenimiento");
$querry->execute();
$sostenimiento = $querry->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/scripts.php' ?>
    <title>Lista de Personal</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de personal</h1>
        <br>
        <table id="tblPersonal">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Curp</th>
                    <th>Nombres</th>
                    <th>Primer Paterno</th>
                    <th>Segundo Materno</th>
                    <th>Función</th>
                    <th>Sostenimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personal as $dataP) :  ?>
                    <tr>
                        <td><?php echo $dataP['idPersonal'] ?></td>
                        <td><?php echo $dataP['curp'] ?></td>
                        <td><?php echo $dataP['nombres'] ?></td>
                        <td><?php echo $dataP['primApellido'] ?></td>
                        <td><?php echo $dataP['segApellido'] ?></td>
                        <td>
                            <?php foreach ($funcion as $dataF) : ?>
                                <?php if ($dataF['idFuncion'] == $dataP['idFuncion']) : ?>
                                    <?php echo $dataF['funcion'] ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php foreach ($sostenimiento as $dataS) : ?>
                                <?php if ($dataS['idSostenimiento'] == $dataP['idSostenimiento']) : ?>
                                    <?php echo $dataS['Sostenimiento'] ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <a class="edit" href="editarPersonal.php?id=<?php echo  $dataP['idPersonal'] ?>"><i class="fa-solid fa-user-pen fa-2x" style="color: #1ce329;"></i> EDITAR</a>

                            |

                            <a class="delete" href="eliminarPersonal.php?id=<?php echo $dataP['idPersonal'] ?>"><i class="fa-solid fa-2x fa-user-large-slash "></i> BORRAR</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>


        </table>
    </section>
    <?php include 'includes/footer.php' ?>
    <script>
        var tabla = new DataTable("#tblPersonal", {
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