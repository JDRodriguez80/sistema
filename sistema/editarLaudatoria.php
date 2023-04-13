<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
$idActa = $_GET['id'];
//checando si se recibio el id

//trayendo datos del acta
$querry = $con->prepare("SELECT laudatorias.idLaudatoria, laudatorias.fecha, laudatorias.motivo, laudatorias.idPersonal, personal.nombres, personal.primApellido, personal.segApellido FROM laudatorias inner join personal on laudatorias.idPersonal=personal.idPersonal WHERE idLaudatoria = :idActa");
$querry->bindParam(":idActa", $idActa);
$querry->execute();
$result = $querry->fetchAll(PDO::FETCH_ASSOC);
//checando vacios
if (!empty($_POST)) {
    //validando campos vacios
    if (empty($_POST['fecha']) || empty($_POST['motivo'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        //checando duplicidad
        $fecha = $_POST['fecha'];
        $motivo = $_POST['motivo'];
        $idPersonal = $_POST['idPersonal'];
        $querry = $con->prepare("SELECT * FROM laudatorias WHERE fecha = :fecha AND motivo = :motivo AND idPersonal = :idPersonal");
        $querry->bindParam(":fecha", $fecha);
        $querry->bindParam(":motivo", $motivo);
        $querry->bindParam(":idPersonal", $idPersonal);
        $querry->execute();
        $result3 = $querry->fetch(PDO::FETCH_ASSOC);
        if ($result3 > 0) {
            $alert = '<p class="msg_error">Esta acta ya existe.</p>';
        } else {
            //actualizando datos
            $querry = $con->prepare("UPDATE laudatorias SET fecha = :fecha, motivo = :motivo, idPersonal = :idPersonal WHERE idLaudatoria = :idActa");
            $querry->bindParam(":fecha", $fecha);
            $querry->bindParam(":motivo", $motivo);
            $querry->bindParam(":idPersonal", $idPersonal);
            $querry->bindParam(":idActa", $idActa);
            $querry->execute();
            if ($querry) {
                $alert = '<p class="msg_save">Acta registrada correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar la acta.</p>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/scripts.php' ?>
    <title>Document</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Acta Laudatoria</h1>
            <?php foreach ($result as $data) : ?>
                
                <br>
                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

                <form action="" method="POST">
                    <br>
                    <label for="nombre">Otorgada a:</label>
                    <select name="idPersonal" id="idPersonal">

                        <?php
                        $query = $con->query("SELECT*FROM personal Where idPersonal=$data[idPersonal]");
                        $ejecutar = $query->fetchAll();
                        ?>
                        <?php
                        foreach ($ejecutar as $opciones) : ?>
                            <option value="<?php echo $opciones['idPersonal'] ?>"><?php echo $opciones['nombres'] ?> <?php echo $opciones['primApellido'] ?> <?php echo $opciones['segApellido']  ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" value="<?php echo $data['fecha'] ?>">
                    <label for="motivo">Motivo</label>
                    <textarea name="motivo" id="motivo" class="cuerpo"><?php echo $data['motivo'] ?></textarea>
                    <ul style=" align-items: flex-end;">
                        <li><input type="submit" value="Editar" class="btn_secondary-color-dark"></li>
                        <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                    </ul>
                <?php endforeach ?>
                </form>
        </div>
    </section>

</body>

</html>