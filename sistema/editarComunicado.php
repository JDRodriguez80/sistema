<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$idComunicado = $_GET['id'];
//checando que se haya recibido un id
if ($idComunicado == "") {
    header("Location: index.php");
}
//checando que el usuario tenga permisos para editar
/* if ($_SESSION['nivelUsuario'] != 1 || $_SESSION['nivelUsuario'] != 2) {
    header("Location: index.php");
} */

if (!empty($_POST)) {
    if (empty($_POST['fecha']) || (empty($_POST['nombre'])) || (empty($_POST['tipo'])) || (empty($_POST['cuerpo']))) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {
        $idPersonal = $_SESSION['idUsuario'];
        $fecha = $_POST['fecha'];
        $nombreComunicado = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $cuerpo = $_POST['cuerpo'];
        $querry = $con->prepare("UPDATE `comunicados` SET `fecha` = :fecha, `nombreComunicado` = :nombreComunicado, `cuerpo` = :cuerpo, `tipo` = :tipo , `idPersonal` = :idPersonal WHERE  `comunicados`.`idComunicado` = :idComunicado");
        $querry->bindParam(':fecha', $fecha);
        $querry->bindParam(':nombreComunicado', $nombreComunicado);
        $querry->bindParam(':cuerpo', $cuerpo);
        $querry->bindParam(':tipo', $tipo);
        $querry->bindParam(':idComunicado', $idComunicado);
        $querry->bindParam(':idPersonal', $idPersonal);
        $querry->execute();
        if ($querry) {
            $alert = '<p class="msg_success"> Comunicado actualizado de manera correcta. </p>';
        } else {
            $alert = '<p class="msg_error"> Fallo en la inserción, favor de checar la información. </p>>';
        }
    }
}
//preparando campos para editar
$querry = $con->prepare("SELECT * FROM `comunicados` WHERE `idComunicado` = :idComunicado");
$querry->bindParam(':idComunicado', $idComunicado);
$querry->execute();
$result = $querry->fetch(PDO::FETCH_ASSOC);

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
                    <input type="text" name="nombre" id="nombre" value="<?php echo $result['nombreComunicado'] ?>">


                    <label for="descripcion">Mensaje</label>
                    <textarea name="cuerpo" id="cuerpoComunicado" class="cuerpo"> <?php echo $result['cuerpo'] ?></textarea>
                    <li>
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="<?php echo $result['fecha'] ?>">
                    </li>
                    <br>
                    <br>

                    <select name="tipo" id="tipo" name="tipo">

                        <?php if ($result['tipo'] == 1) { ?>
                            <option value="1" selected>General</option>
                            <option value="2">Personal</option>
                        <?php } else { ?>
                            <option value="1">General</option>
                            <option value="2" selected>Personal</option>
                        <?php } ?>

                    </select>

                    <br>
                    <br>

                </ul>
                <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Editar" class="btn_secondary-color-dark"></li>
                    <li><input type="button" onclick="window.location.href='listarComunicados.php';" value="Salir" class="btn_Danger"></li>
                </ul>
            </form>
        </div>

    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>