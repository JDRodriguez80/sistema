<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
$idActa = $_GET['id'];
//checando si se recibio el id
if (empty($idActa)) {
    header('Location: listaLaudatorias.php');
}
//trayendo datos del acta
$querry = $con->prepare("SELECT laudatorias.idLaudatoria, laudatorias.fecha, laudatorias.motivo, laudatorias.idPersonal, personal.nombres, personal.primApellido, personal.segApellido FROM laudatorias inner join personal on laudatorias.idPersonal=personal.idPersonal WHERE idLaudatoria = :idActa");
$querry->bindParam(":idActa", $idActa);
$querry->execute();
$result = $querry->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $valores) {
    $idLaudatoria = $valores['idLaudatoria'];
    $fechaOf = $valores['fecha'];
    $cuerpoOf = $valores['motivo'];
    $idPersonal = $valores['idPersonal'];
    $nombres = $valores['nombres'];
    $primApellido = $valores['primApellido'];
    $segApellido = $valores['segApellido'];
    $destinatarioOf = $nombres . ' ' . $primApellido . ' ' . $segApellido;
}
//borrando acta
if (!empty($_POST)) {
    $querry = $con->prepare("DELETE FROM laudatorias WHERE idLaudatoria = :idActa");
    $querry->bindParam(":idActa", $idActa);
    $querry->execute();
    if ($querry) {
        header("LOCATION: listaLaudatorias.php");
        $this->conectar()->close();
    } else {
        echo "Error al eliminar";
    }
}

?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Laudatoria</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <div class="data-delete">
                <form method="POST" action="">
                    <br>
                    <i class="fa-solid fa-trophy fa-5x" style="color:#f15a50"></i>


                    <br>
                    <br>
                    <h2>¿Esta seguro de eliminar esta Acta?</h2>
                    <p>Nombre: <span><?php echo $nombres . $primApellido . $segApellido ?></span></p>
                    <p>Fecha: <span><?php echo $fechaOf ?></span></p>
                    <p>Motivo:
                    <h3> <?php echo $cuerpoOf ?></h3>
                    </p>


                    <input type="submit" value="Aceptar" class="btn_ok">
                    <a href="listarLaudatorias.php" class="btn_cancel">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</body>

</html>

