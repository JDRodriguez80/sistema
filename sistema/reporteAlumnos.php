<?php

require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$grupo = $_GET['id'];
$query = $con->prepare("call spListarAlumno('$grupo')");
$query->setFetchMode(PDO::FETCH_ASSOC);
$query->execute();
$ejecutar = $query->fetchAll();
?>



<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/sistema/css/styleImprimir.css">
    <title>Alumnos | Lista</title>
</head>

<body>

    <section id="container">
        <img class="logo" src="/img/image.png" alt="">
        <h1>Lista de Alumnos</h1>
        <br>
        <table id="tbAlumnos">

            <tr>
                <th>ID</th>
                <th>CURP</th>
                <th>Nombres</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>


            </tr>
            <?php foreach ($ejecutar as $data) : ?>



                <tr>
                    <td><?php echo $data['idAlumno'] ?></td>
                    <td><?php echo $data['curp'] ?></td>
                    <td><?php echo $data['nombre'] ?></td>
                    <td><?php echo $data['primApellido'] ?></td>
                    <td><?php echo $data['segApellido'] ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <br>
        <a href="ListarAlumnos.php" class="btn_secondary-color-dark">Regresar</a>
        <a href="" class="btn_Guardar" onclick="window.print()">Imprimir</a>

    </section>



</body>

</html>