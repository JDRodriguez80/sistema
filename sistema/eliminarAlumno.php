<?php
session_start();


require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
if (!empty($_POST)) {
    $idAlumno = $_REQUEST['id'];
    $querry = $con->prepare("DELETE FROM alumnos WHERE idAlumno=$idAlumno");
    $query_delete = $querry->execute();
    if ($query_delete) {
        header("LOCATION: ListarAlumnos.php");
        $this->conectar()->close();
    } else {
        echo "Error al eliminar";
    }
}
if (empty($_REQUEST['id'])) {
    header("LOCATION: ListarAlumnos.php");
    $this->conectar()->close();
} else {
    $idAlumno = $_REQUEST['id'];
    $querry = $con->prepare("SELECT * FROM alumnos where idAlumno=$idAlumno");
    $querry->execute();

    if ($querry->rowCount() > 0) {
        $data = $querry->fetch(PDO::FETCH_ASSOC);
        $curpAlumno = $data['curp'];
        $nombreAlumno = $data['nombre'];
        $paAlumno = $data['primApellido'];
        $segAlumno = $data["segApellido"];
        $alumno = $nombreAlumno . " " . $paAlumno . " " . $segAlumno;
    } else {
        header("LOCATION: ListarAlumnos.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Alumno</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container"><br>
        <div class="form-Registro2">
            <div class="data_delete">
                <i class="fa-solid fa-graduation-cap fa-7x" style="color:#f15a50"> </i>
                <br>
                <br>
                <br>
                <h2>¿Esta seguro de eliminar a este alumno?</h2>
                <hr>
                <h3>Alumno: <span><?php echo $alumno; ?></span></h3>
                <h3>Curp: <span><?php echo $curpAlumno; ?></span></h3>

                <form method="POST" action="">
                    <input type="hidden" name="idAlumno" value="<?php echo $idAlumno; ?>">
                    <a href="ListarAlumnos.php" class="btn_cancel">Cancelar</a>
                    <input type="submit" value="Aceptar" class="btn_ok">
                </form>
            </div>
        </div>
    </section>


    <?php include "includes/footer.php"; ?>
</body>

</html>