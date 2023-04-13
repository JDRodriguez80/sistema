<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
if (!empty($_POST)) {
    $idPadre = $_REQUEST['id'];
    $query = $con->prepare("DELETE FROM padres WHERE idPadre = :idPadre");
    $query->bindParam(':idPadre', $idPadre);
    $query_delete = $query->execute();
    if ($query_delete) {
        header("LOCATION: listarPadres.php");
    } else {
        echo "Error al eliminar";
    }
}
if (empty($_REQUEST['id'])) {
    header("LOCATION: listarPadres.php");
} else {
    $idPadre = $_REQUEST['id'];
    $querry = $con->prepare("SELECT * FROM padres where idPadre=:idPadre");
    $querry->bindParam(':idPadre', $idPadre);
    $querry->execute();


    if ($querry->rowCount()>0) {
        $data = $querry->fetch(PDO::FETCH_ASSOC);
            $padreCurp = $data['curp'];
            $padreNombre = $data['Nombres'];
            $padrepAp = $data['primApellido'];
            $padresAp = $data["segApellido"];
            $padre = $padreNombre . " " . $padrepAp . " " . $padresAp;
        }
    else {
        header("LOCATION:listarPadres.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Padre</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container"><br>
        <div class="form-Registro2">
            <div class="data_delete">
                <i class="fas fa-users-rays fa-7x" style="color:#f15a50"> </i>
                <br>
                <br>
                <br>
                <h2>¿Esta seguro de eliminar a este padre?</h2>
                <hr>
                <h3>Padre: <span><?php echo $padre; ?></span></h3>

                <form method="POST" action="">
                    <input type="hidden" name="idPadre" value="<?php echo $idPadre; ?>">
                    <a href="listarPadres.php" class="btn_cancel">Cancelar</a>
                    <input type="submit" value="Aceptar" class="btn_ok">
                </form>
            </div>
        </div>
    </section>


    <?php include "includes/footer.php"; ?>
</body>

</html>