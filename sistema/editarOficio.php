<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$idOficio = $_GET['id'];
if (!empty($_POST)) {
    if (empty($_POST['fecha']) || (empty($_POST['asunto'])) || (empty($_POST['destinatario'])) || (empty($_POST['cargo'])) || (empty($_POST['dependencia'])) || (empty($_POST['cuerpo']))) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {
        /* agregar logica de comprobacion de duplicidad */
        $idEmpleado = $_SESSION['idUsuario'];
        $fecha = $_POST['fecha'];
        $asunto = $_POST['asunto'];
        $destinatario = $_POST['destinatario'];
        $cargo = $_POST['cargo'];
        $dependencia = $_POST['dependencia'];
        $cuerpo = $_POST['cuerpo'];
        $querry = $con->prepare("UPDATE `oficios` set fecha=:fecha, asunto=:asunto, destinatario=:destinatario, cargo=:cargo, dependencia=:dependencia,
        cuerpo=:cuerpo,idEmpleado=:idEmpleado WHERE idOficio=:id ");
        $querry->bindParam(':fecha', $fecha);
        $querry->bindParam(':asunto', $asunto);
        $querry->bindParam(':destinatario', $destinatario);
        $querry->bindParam(':cargo', $cargo);
        $querry->bindParam(':dependencia', $dependencia);
        $querry->bindParam(':cuerpo', $cuerpo);
        $querry->bindParam(':idEmpleado', $idEmpleado);
        $querry->bindParam(':id', $idOficio);
        $querry->execute();
        if ($querry) {
            $alert = '<p class="msg_success"> Oficio modificado de manera correcta. </p>';
        } else {
            $alert = '<p class="msg_error"> Fallo en la modificación, favor de checar la información. </p>>';
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

    <title>Crear Oficio</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Edicion de Oficio</h1>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ?></div>
            <form action="" method="post">
                <?php
                $consulta = $con->prepare("SELECT * FROM oficios WHERE idOficio=:idOficio");
                $consulta->bindParam(':idOficio', $idOficio);
                $consulta->execute();
                $ejecutar = $consulta->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php
                foreach ($ejecutar as $valores) :
                    $fechaOf = $valores['fecha'];
                    $asuntoOf = $valores['asunto'];
                    $destinatarioOf = $valores['destinatario'];
                    $cargoOf = $valores['cargo'];
                    $dependenciaOf = $valores['dependencia'];
                    $cuerpoOf = $valores['cuerpo'];
                ?>
                <?php
                endforeach;
                ?>
                <ul>
                    <h5>Datos del Oficio</h5>

                    <li>
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="<?php echo $fechaOf ?>">
                    </li>
                    <li>
                        <label for="asunto">Asunto</label>
                        <input type="text" name="asunto" id="asunto" value="<?php echo $asuntoOf ?>">
                    </li>
                    <li>
                        <label for="destinatario">Destinatario</label>
                        <input type="text" name="destinatario" id="destinatario" value="<?php echo $destinatarioOf ?>">
                    </li>
                    <li>
                        <label for="cargo">Cargo</label>
                        <input type="text" name="cargo" id="cargo" value="<?php echo $cargoOf ?>">
                    </li>
                    <li>
                        <label for="dependencia">Dependencia</label>
                        <input type="text" name="dependencia" id="dependencia" value="<?php echo $dependenciaOf ?>">
                    </li>
                    <ul>
                        <br>
                        <p>La que subscribe Lic. Martha Genoveva Jiménez Limón, directora del centro de atención múltiple “Prof. Nicasio Zúñiga Huerta”, perteneciente a la zona escolar 09 de educación especial</p>

                    </ul>
                    <label for="direccion">Cuerpo</label>
                    <textarea name="cuerpo" class="cuerpo" id="cuerpo"><?php echo $cuerpoOf ?></textarea>

                    <ul style="align-items: flex-end;">
                        <li><input type="submit" value="editar oficio" class="btn_secondary-color-dark"></li>
                        <li><input type="button" onclick="window.location.href='listarOficios.php';" value="Salir" class="btn_Danger"></li>
                    </ul>




    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>