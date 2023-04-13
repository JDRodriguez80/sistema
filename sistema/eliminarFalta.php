<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$idFalta = $_GET['id'];
$alert = '';
//igualando los datos de la base de datos a los campos del formulario
$query = $con->prepare("SELECT * FROM faltas WHERE idFalta=$idFalta");
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);
///igualando los campos del nombre del personal
$query2 = $con->prepare("SELECT * FROM personal WHERE idPersonal=$resultado[idPersonal]");
$query2->execute();
$resultado2 = $query2->fetch(PDO::FETCH_ASSOC);
$nombre = $resultado2['nombres'] . " " . $resultado2['primApellido'] . " " . $resultado2['segApellido'];
//borrando el permiso
if (!empty($_POST)) {

    $querry = $con->prepare("DELETE FROM faltas WHERE idFalta=:idFalta");
    $querry->bindParam(':idFalta', $idFalta);
    $query_delete = $querry->execute();
    if ($query_delete) {
        header("LOCATION: listarFaltas.php");
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
    <title>Eliminar Falta</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <div class="data-delete">
                <form method="POST" action="">
                    <br>
                    <i class="fa-solid fa-user-clock fa-5x" style="color:#f15a50"></i>


                    <br>
                    <br>
                    <h2>¿Esta seguro de eliminar esta falta?</h2>
                    <p>Nombre: <span><?php echo $nombre; ?></span></p>
                    <p>Fecha: <span><?php echo $resultado['fecha']; ?></span></p>
                    <?php if ($resultado['idTipoFalta'] == 1) {
                        $tipoFaltaFo = "Inasistencia";
                    } else {
                        $tipoFaltaFo = "Retardo";
                    }
                    ?>
                    <p>Tipo de falta: <span><?php echo $tipoFaltaFo; ?></span></p>

                    <input type="submit" value="Aceptar" class="btn_ok">
                    <a href="listarFaltas.php" class="btn_cancel">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</body>

</html>