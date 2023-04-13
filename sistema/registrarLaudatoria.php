<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
//cehando por vacios
if (!empty($_POST)) {
    //validando por campos vacios
    if (empty($_POST['fecha']) || empty($_POST['motivo']) || empty($_POST['idPersonal']) || empty($_POST['idPersonal'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        //checando por duplicidad
        $fecha = $_POST['fecha'];
        $motivo = $_POST['motivo'];
        $idPersonal = $_POST['idPersonal'];
        $querry = $con->prepare("SELECT * FROM laudatorias WHERE fecha = :fecha AND motivo = :motivo AND idPersonal = :idPersonal");
        $querry->bindParam(":fecha", $fecha);
        $querry->bindParam(":motivo", $motivo);
        $querry->bindParam(":idPersonal", $idPersonal);
        $querry->execute();
        $result = $querry->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            $alert = '<p class="msg_error">Esta acta ya existe.</p>';
        } else {
            //insertando datos
            $querry = $con->prepare("INSERT INTO laudatorias(fecha,motivo,idPersonal) VALUES(:fecha,:motivo,:idPersonal)");
            $querry->bindParam(":fecha", $fecha);
            $querry->bindParam(":motivo", $motivo);
            $querry->bindParam(":idPersonal", $idPersonal);
            $querry->execute();
            if ($querry) {
                $alert = '<p class="msg_save">Acta registrada correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al registrar la acta.</p>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include 'includes/scripts.php' ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta Laudatoria</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Acta Laudatoria</h1>
            <br>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="POST">
                <br>
                <label for="nombre">Otorgada a:</label>
                <select name="idPersonal" id="idPersonal">

                    <?php
                    $query = $con->query("SELECT*FROM personal ");
                    $ejecutar = $query->fetchAll();
                    ?>
                    <?php
                    foreach ($ejecutar as $opciones) : ?>
                        <option value="<?php echo $opciones['idPersonal'] ?>"><?php echo $opciones['nombres'] ?> <?php echo $opciones['primApellido'] ?> <?php echo $opciones['segApellido']  ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" placeholder="Fecha">
                <label for="motivo">Motivo</label>
                <textarea name="motivo" id="motivo" class="cuerpo"></textarea>
                <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Registrar" class="btn_Guardar"></li>
                    <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                </ul>
            </form>
        </div>
    </section>
</body>

</html>