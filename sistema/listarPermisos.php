<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
//retreiving data from the form database
$querry = $con->prepare("SELECT permisos.idPermiso, permisos.idPersonal, permisos.tipoPermiso, permisos.fechaInicio, permisos.fechafin, permisos.fechaAu, permisos.observaciones, permisos.tipoEmpleado,
personal.nombres, personal.primApellido, personal.segApellido FROM permisos INNER JOIN personal ON permisos.idPersonal = personal.idPersonal");
$querry->execute();
$result = $querry->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos | Listado</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
        <h1>Permisos Otorgados</h1>
        <br>
        <table id="tbPermisos">
            <thead>
                <tr>
                    <th>Id Permiso</th>
                    <th>Otorgado A:</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Término</th>
                    <th>Fecha de Autorización</th>
                    <th>Tipo de Permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $data) : ?>
                    <tr>
                        <td><?php echo $data['idPermiso'] ?></td>
                        <td><?php echo $data['nombres'] . " " . $data['primApellido'] . " " . $data['segApellido'] ?></td>
                        <td><?php echo $data['fechaInicio'] ?></td>
                        <td><?php echo $data['fechafin'] ?></td>
                        <td><?php echo $data['fechaAu'] ?></td>
                        <?php if ($data['tipoPermiso'] == 1) {
                            $tipoPermiso = "Personal";
                        } elseif ($data['tipoPermiso'] == 2) {
                            $tipoPermiso = "Incapacidad";
                        } elseif ($data['tipoPermiso'] == 3) {
                            $tipoPermiso = "Sindical";
                        } elseif ($data['tipoPermiso'] == 4) {
                            $tipoPermiso = "Económico";
                        } ?>
                        <td><?php echo $tipoPermiso ?></td>
                        <td>
                            <a class="edit" href="editarPermiso.php?id=<?php echo  $data['idPermiso'] ?>"><i class="fa-solid fa-file-signature fa-2x" style="color: #1ce329;"></i> EDITAR</a>

                            |

                            <a class="delete" href="eliminarPermiso.php?id=<?php echo $data['idPermiso'] ?>"><i class="fa-solid fa-2x fa-file-circle-xmark "></i> BORRAR</a>


                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <?php include "includes/footer.php" ?>
    <script>
        var tabla = new DataTable("#tbPermisos", {
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