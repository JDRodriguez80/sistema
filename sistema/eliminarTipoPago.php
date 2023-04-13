<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$idPago = $_GET['id'];
//checando por privilegios de usuario
$nivel = $_SESSION['nivelUsuario'];
if ($nivel != 1 || $nivel != 2) {
    header('location index.php');
}
//trayendo datos
$querry = $con->prepare("SELECT * FROM tipopago WHERE idTipoPago = :idPago");
$querry->bindParam(":idPago", $idPago);
$querry->execute();
$result = $querry->fetchAll(PDO::FETCH_ASSOC);
//borrando
if (!empty($_POST)) {
    $querry = $con->prepare("DELETE FROM tipopago WHERE idTipoPago = :idPago");
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
    <?php include "includes/scripts.php"; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar | Tipo de Pago</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="form-Registro2">
            <div class="data-delete">
                <i class="fa-solid fa-money-check-dollar fa-4x" style="color:#f15a50"></i>
                <br>
                <br>
                <br>
                <h2>¿Esta seguro de eliminar tipo de pago?</h2>
                <hr>
                <?php foreach ($result as $data) { ?>
                    <h3>Nombre: <span><?php echo $data['nombrePago']; ?></span></h3>
                    <h3>Descripción: <span><?php echo $data['descripcion']; ?></span></h3>

                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $idPago; ?>">
                        <a href="listarTipoPago.php" class="btn_cancel">Cancelar</a>
                        <input type="submit" value="Aceptar" class="btn_ok">
                    <?php } ?>
                    </form>
            </div>
        </div>
    </section>

</body>

</html>