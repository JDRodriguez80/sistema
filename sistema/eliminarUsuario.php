<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();


if (!empty($_POST)) {
    $id = $_REQUEST['id'];
    $query=$con->prepare("DELETE FROM usuarios WHERE idUsuario=:id");
    $query->bindParam(":id", $id);
    $query_delete = $query->execute();
    if ($query_delete) {
        header("LOCATION: ListarUsuarios.php");
    } else {
        echo "Error al eliminar";
    }
}
if (empty($_REQUEST['id'])) {
    header("LOCATION: ListarUsuarios.php");
    
} else {
    $idUsuario = $_REQUEST['id'];
    $query = $con->prepare("SELECT * FROM usuarios WHERE idUsuario=:id");
    $query->bindParam(":id", $idUsuario);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
            $usuario = $data['usuario'];
            $email = $data['email'];
            $nivelUsuario = $data['nivelUsuario'];
        
    } else {
        header("LOCATION:ListarUsuarios.php");
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
                <h2>¿Esta seguro de eliminar este usuario?</h2>
                <hr>
                

                <form method="POST" action="">
                    <input type="hidden" name="idu" value="<?php echo $idUsuario; ?>">
                    <p><span><?php echo $usuario; ?></span></p>
                    <a href="ListarUsuarios.php" class="btn_cancel">Cancelar</a>
                    <input type="submit" value="Aceptar" class="btn_ok">
                </form>
            </div>
        </div>
    </section>


    <?php include "includes/footer.php"; ?>
</body>

</html>