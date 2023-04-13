<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
if (!empty($_POST)) {
    $alert = "";
    $idComunicado = 0;
    if (empty($_POST['nombre']) || (empty($_POST['mensaje'])) || (empty($_POST['fecha'])) || (empty($_POST['tipoComunicado']))) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {
        $idEmpleado = $_SESSION['idUsuario'];
        $fecha = $_POST['fecha'];
        $nombre = $_POST['nombre'];
        $mensaje = $_POST['mensaje'];
        $tipoComunicado = $_POST['tipoComunicado'];
        $querry = $con->prepare("INSERT INTO `comunicados` (`fecha`, `nombreComunicado`, `cuerpo`, `idPersonal`, `tipo`) VALUES (:fecha, :nombre, :mensaje, :idEmpleado, :tipoComunicado)");
        $querry->bindParam(':fecha', $fecha);
        $querry->bindParam(':nombre', $nombre);
        $querry->bindParam(':mensaje', $mensaje);
        $querry->bindParam(':idEmpleado', $idEmpleado);
        $querry->bindParam(':tipoComunicado', $tipoComunicado);
        $querry->execute();
        if ($querry) {
            $alert = '<p class="msg_success"> Comunicado agregado de manera correcta. </p>';
        } else {
            $alert = '<p class="msg_error"> Fallo en la inserción, favor de checar la información. </p>>';
        }
    }
}

?>

<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Crear Comunicado</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Crear Comunicado</h1>

            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post">
                <ul>

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre del comunicado">


                    <label for="descripcion">Mensaje</label>
                    <textarea name="mensaje" id="cuerpo" class="cuerpo"></textarea>
                    <li>
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" placeholder="Fecha del comunicado">
                    </li>
                    <br>
                    <br>

                    <select name="tipoComunicado" id="tipo" name="tipo">
                        <option value="0">Seleccione un tipo de comunicado</option>
                        <option value="1">General</option>
                        <option value="2">Personal</option>
                    </select>

                    <br>
                    <br>

                </ul>
                <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Crear" class="btn_Guardar"></li>
                    <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                </ul>
            </form>
        </div>

    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>