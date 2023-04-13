<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$idPadre = $_GET['id'];
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['primApellido']) || empty($_POST['telefono']) || empty($_POST['oficio']) || empty($_POST['curp']) || empty($_POST['escolaridad'])) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos. </p>';
    } else {
        $idPadre = $_GET['id'];
        $nombre = $_POST['nombre'];
        $primApellido = $_POST['primApellido'];
        $segApellido = $_POST['segApellido'];
        $telefono = $_POST['telefono'];
        $oficio = $_POST['oficio'];
        $curp = $_POST['curp'];
        $escolaridad = $_POST['escolaridad'];
        $user = $_POST['usuario'];
        $email = $_POST['email'];
        $querry = $con->prepare("UPDATE padres SET`Nombres` = :nombre, `primApellido` = :primApellido, `segApellido` = :segApellido, `telefono` = :telefono, `oficio` = :oficio, `curp` = :curp, `idEcolaridad` = :escolaridad WHERE `idPadre` = :idPadre;");
        $querry->bindParam(':nombre', $nombre);
        $querry->bindParam(':primApellido', $primApellido);
        $querry->bindParam(':segApellido', $segApellido);
        $querry->bindParam(':telefono', $telefono);
        $querry->bindParam(':oficio', $oficio);
        $querry->bindParam(':curp', $curp);
        $querry->bindParam(':escolaridad', $escolaridad);
        $querry->bindParam(':idPadre', $idPadre);
        $querry->execute();



        if ($querry) {
            $alert = '<p class="msg_success"> Padre Editado de manera correcta</p>';
            header("LOCATION:listarPadres.php");
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
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Registrar Padre</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Editar Padre</h1>

            <div class="alert"><?php echo isset($alert) ? $alert : '' ?> </div>
            <form action="" method="post">

                <?php

                $consulta = $con->prepare("SELECT * From padres inner join usuarios u on padres.idUsuario = u.idUsuario WHERE idPadre=:idPadre");
                $consulta->bindParam(':idPadre', $idPadre);
                $consulta->execute();
                $ejecutar = $consulta->fetchAll(PDO::FETCH_ASSOC);



                ?>
                <?php
                foreach ($ejecutar as $valores) :
                    $idPadre2 = $valores['idPadre'];
                    $nombrePadre = $valores['Nombres'];
                    $primApPadre = $valores['primApellido'];
                    $segApPadre = $valores['segApellido'];
                    $telfonoPadre = $valores['telefono'];
                    $oficioPadre = $valores['oficio'];
                    $curpPadre = $valores['curp'];
                    $emailPadre = $valores['email'];
                    $usuarioPadre = $valores['usuario'];
                    $escoPadre = $valores['idEcolaridad'];
                ?>
                <?php
                endforeach;
                ?>

                <label for="nombres">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $nombrePadre ?>" ">
                <label for=" primApellido">Primer Apellido:</label>
                <input type="text" name="primApellido" id="primApellido" value="<?php echo $primApPadre ?>">
                <label for="segApellido">Segundo Apellido:</label>
                <input type="text" name="segApellido" id="segApellido" value="<?php echo $segApPadre ?>">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" value="<?php echo $telfonoPadre ?>">
                <label for="oficio">Oficio:</label>
                <input type="text" name="oficio" id="oficio" value="<?php echo $oficioPadre ?>">
                <label for="curp">CURP:</label>
                <input type="text" name="curp" id="curp" value="<?php echo $curpPadre ?>">
                <label for="email">Correo Electrónico:</label>
                <input type="text" name="email" id="email" value="<?php echo $emailPadre ?>">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" value="<?php echo $usuarioPadre ?>">
                <label for="escolaridad">Escolaridad:</label>
                <select name="escolaridad" id="escolaridad">

                    <?php
                    $querry = $con->prepare("SELECT * FROM escolaridad");
                    $querry->execute();
                    $ejecutar = $querry->fetchAll(PDO::FETCH_ASSOC);


                    ?>
                    <?php foreach ($ejecutar as $opciones) : ?>
                        <option value="<?php echo $opciones['idEscolaridad'] ?>"><?php echo $opciones['escolaridad'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Editar Padre" class="btn_secondary-color-dark">

            </form>

        </div>
    </section>
    <?php include "includes/footer.php"; ?>

</body>

</html>