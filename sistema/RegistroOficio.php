<?php
require '../conexion.php';
session_start();

$conn = new Database();
$con = $conn->conectar();
if (!empty($_POST)) {
    $alert = "";
    $idOficio = 0;

    if (empty($_POST['fecha']) || (empty($_POST['asunto'])) || (empty($_POST['destinatario'])) || (empty($_POST['cargo'])) || (empty($_POST['dependencia'])) || (empty($_POST['cuerpo']))) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {
        
        $idEmpleado = $_SESSION['idUsuario'];
        $fecha = $_POST['fecha'];
        $asunto = $_POST['asunto'];
        $destinatario = $_POST['destinatario'];
        $cargo = $_POST['cargo'];
        $dependencia = $_POST['dependencia'];
        $cuerpo = $_POST['cuerpo'];
        $querry = $con->prepare("INSERT INTO `oficios` (`fecha`, `asunto`, `destinatario`, `cargo`, `dependencia`, `cuerpo`, `idEmpleado` ) VALUES (:fecha, :asunto, :destinatario, :cargo, :dependencia, :cuerpo, :idEmpleado)");
        $querry->bindParam(':fecha', $fecha);
        $querry->bindParam(':asunto', $asunto);
        $querry->bindParam(':destinatario', $destinatario);
        $querry->bindParam(':cargo', $cargo);
        $querry->bindParam(':dependencia', $dependencia);
        $querry->bindParam(':cuerpo', $cuerpo);
        $querry->bindParam(':idEmpleado', $idEmpleado);
        $querry->execute();
        if ($querry) {
            $alert = '<p class="msg_success"> Oficio agregado de manera correcta. </p>';
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

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "includes/scripts.php"; ?>
    <title>Crear Oficio</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Crear Oficio</h1>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ?></div>
            <form action="" method="post">
                <ul>
                    <h5>Datos del Oficio</h5>

                    <li>
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" placeholder="Fecha">
                    </li>
                    <li>
                        <label for="asunto">Asunto</label>
                        <input type="text" name="asunto" id="asunto" placeholder="Asunto">
                    </li>
                    <li>
                        <label for="destinatario">Destinatario</label>
                        <input type="text" name="destinatario" id="destinatario" placeholder="Destinatario">
                    </li>
                    <li>
                        <label for="cargo">Cargo</label>
                        <input type="text" name="cargo" id="cargo" placeholder="Cargo">
                    </li>
                    <li>
                        <label for="dependencia">Dependencia</label>
                        <input type="text" name="dependencia" id="dependencia" placeholder="Dependencia">
                    </li>
                    <ul>
                        <br>
                        <p>La que subscribe Lic. Martha Genoveva Jiménez Limón, directora del centro de atención múltiple “Prof. Nicasio Zúñiga Huerta”, perteneciente a la zona escolar 09 de educación especial</p>

                    </ul>
                    <label for="direccion">Cuerpo</label>
                    <textarea class="cuerpo" name="cuerpo" id="cuerpo"></textarea>

                    <ul style=" align-items: flex-end;">
                        <li><input type="submit" value="Crear oficio" class="btn_Guardar"></li>
                        <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                    </ul>




    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>