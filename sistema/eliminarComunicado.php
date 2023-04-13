<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$idComunicado = $_GET['id'];


if (!empty($_POST)) {
    
    $querry = $con->prepare("DELETE FROM comunicados WHERE idComunicado=:idComunicado");
    $querry->bindParam(':idComunicado', $idComunicado);
    $query_delete = $querry->execute();
    if ($query_delete) {
        header("LOCATION: listarComunicados.php");
        $this->conectar()->close();
    } else {
        echo "Error al eliminar";
    }
}
if (empty($_REQUEST['id'])) {
    header("LOCATION: listarComunicados.php");
    $this->conectar()->close();
} else {
    $idComunicado = $_REQUEST['id'];
    $querry = $con->prepare("SELECT * FROM comunicados where idComunicado=$idComunicado");
    $querry->execute();

    if ($querry->rowCount() > 0) {
        $data = $querry->fetch(PDO::FETCH_ASSOC);
        $idCom = $data['idComunicado'];
        $nombreCom = $data['nombreComunicado'];
        $fechaCom = $data['fecha'];
        $tipoCom = $data['tipo'];
    } else {
        header("LOCATION: listarComunicados.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <?php include "includes/scripts.php"; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="form-Registro2">
            <div class="data-delete">
                <i class="fas fa-envelope-open-text fa-7x" style="color:#f15a50"></i>
                <br>
                <br>
                <br>
                <h2>¿Esta seguro de eliminar este comunicado?</h2>
                <p>Comunicado: <span><?php echo $nombreCom; ?></span></p>
                <p>Fecha: <span><?php echo $fechaCom; ?></span></p>
                <p>Tipo: <span><?php echo $tipoCom; ?></span></p>
                <form method="POST" action="">
                    <input type="submit" value="Aceptar" class="btn_ok">
                    <a href="listarComunicados.php" class="btn_cancel">Cancelar</a>
                </form>
            </div>
        </div>
    </section>

</body>

</html>