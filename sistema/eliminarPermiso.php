<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$idPermiso = $_GET['id'];
$alert = '';
//igualando los datos de la base de datos a los campos del formulario
$query = $con->prepare("SELECT * FROM permisos WHERE idPermiso=$idPermiso");
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);
///igualando los campos del nombre del personal
$query2 = $con->prepare("SELECT * FROM personal WHERE idPersonal=$resultado[idPersonal]");
$query2->execute();
$resultado2 = $query2->fetch(PDO::FETCH_ASSOC);
$nombreCom = $resultado2['nombres'] . " " . $resultado2['primApellido'] . " " . $resultado2['segApellido'];
//borrando el permiso
if (!empty($_POST)) {

    $querry = $con->prepare("DELETE FROM permisos WHERE idPersmiso=:idPermiso");
    $querry->bindParam(':idPermiso', $idPermiso);
    $query_delete = $querry->execute();
    if ($query_delete) {
        header("LOCATION: listarPermisos.php");
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
    <title>Eliminar Permiso</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <div class="data-delete">
                <i class="fas fa-envelope-open-text fa-7x" style="color:#f15a50"></i>
                <br>
                <br>
                <br>
                <h2>¿Esta seguro de eliminar este permiso?</h2>
                <p>Otorgado a: <span><?php echo $nombreCom; ?></span></p>
                <p>Fecha: <span><?php echo $resultado['fechaAu']; ?></span></p>
                <?php if ($resultado['tipoPermiso'] == 1) {
                    $tipoPermisoFo = "Personal";
                } elseif ($resultado['tipoPermiso'] == 2) {
                    $tipoPermisoFo = "Incapacidad";
                } elseif ($resultado['tipoPermiso'] == 3) {
                    $tipoPermisoFo = "Sindical";
                } elseif ($resultado['tipoPermiso'] == 4) {
                    $tipoPermisoFo = "Económico";
                } ?>
                <p>Tipo: <span><?php echo $tipoPermisoFo; ?></span></p>
                <form method="POST" action="">
                    <input type="submit" value="Aceptar" class="btn_ok">
                    <a href="listarPermisos.php" class="btn_cancel">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</body>

</html>