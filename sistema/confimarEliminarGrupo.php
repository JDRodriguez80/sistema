<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();



if (!empty($_POST)) {
    $idGrupo = $_REQUEST['id'];
    $querry = $con->prepare("DELETE FROM grupo WHERE idGrupo=:idGrupo");
    $querry->bindParam(':idGrupo', $idGrupo);
    $querry->execute();

    if ($querry) {
        header("LOCATION: listaGrupo.php");
    } else {
        echo "Error al eliminar";
    }
}
if (empty($_REQUEST['id'])) {
    header("LOCATION: listaGrupo.php");
} else {
    $idGrupo = $_REQUEST['id'];
    $querry = $con->prepare("SELECT * FROM grupo where idGrupo=:idGrupo");
    $querry->bindParam(':idGrupo', $idGrupo);
    $querry->execute();
    if ($querry->rowCount() > 0) {
        $data = $querry->fetch(PDO::FETCH_ASSOC);
        $grupo = $data['grupo'];
    } else {
        header("LOCATION:listaGrupo.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Grupo</title>
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
                <h2>¿Esta seguro de eliminar este Grupo?</h2>
                <hr>
                <p>Grupo: <span><?php echo $grupo; ?></span></p>

                <form method="POST" action="">
                    <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                    <a href="listaGrupo.php" class="btn_cancel">Cancelar</a>
                    <input type="submit" value="Aceptar" class="btn_ok">
                </form>
            </div>
        </div>
    </section>


    <?php include "includes/footer.php"; ?>
</body>

</html>