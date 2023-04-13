<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$idPersonal = $_GET['id'];
$alert = '';
//igualando los datos de la base de datos a los campos del formulario
$query = $con->prepare("SELECT * FROM personal WHERE idPersonal=$idPersonal");
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);
//borrando el personal
if (!empty($_POST)) {
    $querry = $con->prepare("DELETE FROM personal WHERE idPersonal=:idPersonal");
    $querry->bindParam(':idPersonal', $idPersonal);
    $query_delete = $querry->execute();
    if ($query_delete) {
        header("LOCATION: listarPersonal.php");
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
    <title>Eliminar Personal</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <section id="container">
        <div class="form-Registro2">
            <form method="POST" action="">
                <br>
                <i class="fas fa-user-large-slash fa-7x" style="color:#f15a50"></i>

                <br>
                <br>
                <h2>¿Esta seguro de eliminar a esta persona?</h2>
                <p>Nombre: <span><?php echo $resultado['nombres'] . " " . $resultado['primApellido'] . " " . $resultado['segApellido']; ?></span></p>
                <p>Curp: <span><?php echo $resultado['curp'] ?></span></p>
                <input type="submit" value="Aceptar" class="btn_ok">
                <a href="listarPersonal.php" class="btn_cancel">Cancelar</a>
            </form>
        </div>
    </section>

</body>

</html>