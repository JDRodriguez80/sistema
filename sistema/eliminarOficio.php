<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();


if (!empty($_POST)) {
    $idOficio = $_GET['id'];
    $querry = $con->prepare("DELETE FROM oficios WHERE idOficio=:idOficio");
    $querry->bindParam(':idOficio', $idOficio);
    $query_delete = $querry->execute();
    if ($query_delete) {
        header("LOCATION: listarOficios.php");
        $this->conectar()->close();
    } else {
        echo "Error al eliminar";
    }
}
if (empty($_REQUEST['id'])) {
    header("LOCATION: listarOficios.php");
    $this->conectar()->close();
} else {
    $idOficio = $_REQUEST['id'];
    $querry = $con->prepare("SELECT * FROM oficios where idOficio=$idOficio");
    $querry->execute();

    if ($querry->rowCount() > 0) {
        $data = $querry->fetch(PDO::FETCH_ASSOC);
        $idOf = $data['idOficio'];
        $destinatarioOf = $data['destinatario'];
        $dependenciaOf = $data['dependencia'];
        $asuntoOf = $data['asunto'];
        $fechaOf = $data['fecha'];
    } else {
        header("LOCATION: listarOficios.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar | Oficio</title>
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
                <h2>¿Esta seguro de eliminar este oficio?</h2>
                <hr>
                <h3>Destinatario: <span><?php echo $destinatarioOf; ?></span></h3>
                <h3>Dependencia: <span><?php echo $dependenciaOf; ?></span></h3>
                <h3>Asunto: <span><?php echo $asuntoOf; ?></span></h3>
                <h3>Fecha: <span><?php echo $fechaOf; ?></span></h3>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $idOf; ?>">
                    <a href="listarOficios.php" class="btn_cancel">Cancelar</a>
                    <input type="submit" value="Aceptar" class="btn_ok">
                </form>
            </div>
        </div>
    </section>

</body>

</html>