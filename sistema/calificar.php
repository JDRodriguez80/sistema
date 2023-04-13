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
$querry = $con->prepare("SELECT * FROM alumnos WHERE idGrupo=:idGrupo ORDER BY curp ASC");
$querry->bindParam(':idGrupo', $grupoId);
$querry->execute();
$alumnos = $querry->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/scripts.php' ?>
    <title>Calificaciones</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Listado de alumnos</h1>
            <h3>Grupo: <?php echo $grupo ?></h3>
            <h3>Responsable: <?php echo $nombre ?> </h3>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <br>
            <table>

                <tr>
                    <th>ID</th>
                    <th>CURP</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Acciones</th>
                </tr>
                <tr>
                    <?php foreach ($alumnos as $alumno) : ?>
                        <td><?php echo $alumno['idAlumno'] ?></td>
                        <td><?php echo $alumno['curp'] ?></td>
                        <td><?php echo $alumno['nombre'] ?></td>
                        <td><?php echo $alumno['primApellido'] ?></td>
                        <td><?php echo $alumno['segApellido'] ?></td>
                        <td>
                            <a class="edit" href="registrarEvaluacion.php?id=<?php echo $alumno['idAlumno'] ?>"><i class="fa-solid fa-2x fa-id-card"></i> Calificar</a>
                        </td>

                </tr>
            <?php endforeach; ?>

            </table>
        </div>
    </section>
</body>

</html>