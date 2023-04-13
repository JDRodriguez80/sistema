<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
//trayendo el grupo asignado al usuario
$usuario = $_SESSION['idUsuario'];

//seleccionado el id de personal
$querry = $con->prepare("SELECT * FROM personal WHERE idUsuario=:idUsuario");
$querry->bindParam(':idUsuario', $usuario);
$querry->execute();
$personal = $querry->fetch(PDO::FETCH_ASSOC);
$idPersonal = $personal['idPersonal'];
$nombre = $personal['nombres'] . " " . $personal['primApellido'] . " " . $personal['segApellido'];

//seleccionando el grupo asignado al personal
$querry = $con->prepare("SELECT * FROM grupo WHERE idPersonal=:idPersonal");
$querry->bindParam(':idPersonal', $idPersonal);
$querry->execute();
$grupos = $querry->fetch(PDO::FETCH_ASSOC);
$grupoId = $grupos['idGrupo'];
$grupo = $grupos['grupo'];
//seleccionando los alumnos del grupo
$querry2 = $con->prepare("SELECT * FROM alumnos inner JOIN evaluaciones on alumnos.idAlumno=evaluaciones.idAlumno WHERE idGrupo=:idGrupo ORDER BY curp ASC");
$querry2->bindParam(':idGrupo', $grupoId);
$querry2->execute();
$alumnos = $querry2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/scripts.php' ?>
    <title>Document</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">

        <h1>Listado de alumnos</h1>
        <h3>Grupo: <?php echo $grupo ?></h3>
        <h3>Responsable: <?php echo $nombre ?> </h3>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
        <br>
        <table id="tbCal" class="calif">

            <thead>
                <tr>
                    <th>CURP</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Español</th>
                    <th>Mat</th>
                    <th>L. Ext</th>
                    <th>C. Nat</th>
                    <th>His</th>
                    <th>C y E.</th>
                    <th>Arte</th>
                    <th>Ed. Fís</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $data) : ?>
                    <tr>
                        <td class="cal"><?php echo $data['curp'] ?></td>
                        <td class="cal"><?php echo $data['nombre'] ?></td>
                        <td class="cal"><?php echo $data['primApellido'] ?></td>
                        <td class="cal"><?php echo $data['segApellido'] ?></td>
                        <td class="cal"><?php echo $data['esProm'] ?></td>
                        <td class="cal"><?php echo $data['matProm'] ?></td>
                        <td class="cal"><?php echo $data['extProm'] ?></td>
                        <td class="cal"><?php echo $data['natProm'] ?></td>
                        <td class="cal"><?php echo $data['hisProm'] ?></td>
                        <td class="cal"><?php echo $data['civProm'] ?></td>
                        <td class="cal"><?php echo $data['artProm'] ?></td>
                        <td class="cal"><?php echo $data['fisProm'] ?></td>
                        <td>
                            <a class="edit" href="editarCalificaciones.php?id=<?php echo  $data['idAlumno'] ?>"><i class="fa-solid fa-file-signature fa-2x" style="color: #1ce329;"></i> EDITAR</a>
                            |
                            <a class="PDF" href="../sistema/Formas/reporteCalificacionPdf.php?id=<?php echo $data['idAlumno']?>&grupo=<?php echo $grupoId?>"><i class="fa-solid fa-print fa-2x"></i> Imprimir</a>


                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </section>
    <?php include 'includes/footer.php' ?>
    <script>
        var tabla = new DataTable("#tbCal", {
            searchable: true,
            perPage: 5,
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