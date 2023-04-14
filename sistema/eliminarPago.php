<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
//debug
$idPago = 10;
//$idPago = $_GET['id'];
//checando por privilegios de usuario
$nivel = $_SESSION['nivelUsuario'];
if ($nivel != 1 || $nivel != 2) {
    header('location index.php');
}
//checando si se recibio el id del pago
if (empty($idPago)) {
    header('location: index.php');
}
//trayendo la informacion del pago
$querry = $con->prepare("SELECT * FROM pagos inner join alumnos on pagos.idAlumno = alumnos.idAlumno inner join tipoPago on pagos.idTipoPago = tipoPago.idTipoPago INNER join personal on pagos.idPersonal=personal.idPersonal where pagos.idPago = $idPago");
$querry->execute();
$datos = $querry->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos as $dato) {
    $idAlumno = $dato['idAlumno'];
    $idGrupo = $dato['idGrupo'];
    $idTipoPago = $dato['idTipoPago'];
    $fecha = $dato['fechaPago'];
    $abono = $dato['abono'];
    $total = $dato['total'];
    $nombreAlumno = $dato['nombre'] . " " . $dato['primApellido'] . " " . $dato['segApellido'];
    $curp = $dato['curp'];
    $concepto = $dato['nombrePago'];
}
//borrar el pago
if (!empty($_POST)) {
    $querry = $con->prepare("DELETE FROM pagos WHERE idPago = :idPago");
    $querry->bindParam(":idPago", $idPago);
    $querry->execute();
    if ($querry) {
        header("LOCATION: listarTipoPago.php");
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
    <?php include 'includes/scripts.php' ?>
    <title>Document</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <div class="data-delete">
                <i class="fa-solid fa-money-check-dollar fa-4x" style="color:#f15a50"></i>
                <br>
                <br>
                <br>
                <h2>¿Esta seguro de eliminar este pago?</h2>
                <Br>

                <form method="POST" action="">
                    <h3>Nombre del alumno: <span><?php echo $nombreAlumno; ?></span></h3>
                    <h3>Curp: <span><?php echo $curp ?></span></h3>
                    <h3>Fecha: <span><?php echo $fecha; ?></span></h3>
                    <h3>Monto: <span>$<?php echo $abono; ?></span></h3>
                    <h3>Concepto: <span><?php echo $concepto; ?></span></h3>


                    <input type="hidden" name="id" value="<?php echo $idPago; ?>">
                    <a href="listarPagos.php" class="btn_cancel">Cancelar</a>
                    <input type="submit" value="Aceptar" class="btn_ok">

                </form>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php' ?>
</body>

</html>