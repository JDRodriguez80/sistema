<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
//checar por vacios
if (!empty($_POST)) {
    if (empty($_POST['idPersonal']) || empty($_POST['fechaFalta']) || empty($_POST['tipoFalta']) || empty($_POST['observaciones'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        $idPersonal = $_POST['idPersonal'];
        $fechaFalta = $_POST['fechaFalta'];
        $tipoFalta = $_POST['tipoFalta'];
        $observaciones = $_POST['observaciones'];
        $query = $con->prepare("INSERT INTO faltas(idPersonal,fecha,idTipoFalta,observaciones) VALUES(:idPersonal,:fechaFalta,:tipoFalta,:observaciones)");
        $query->bindParam(':idPersonal', $idPersonal);
        $query->bindParam(':fechaFalta', $fechaFalta);
        $query->bindParam(':tipoFalta', $tipoFalta);
        $query->bindParam(':observaciones', $observaciones);
        $query->execute();
        if ($query) {
            $alert = '<p class="msg_save">Falta registrada correctamente</p>';
        } else {
            $alert = '<p class="msg_error">Error al registrar la falta</p>';
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
    <title>Faltas y Retardos</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <br>
            <h1>Registro de faltas y retardos</h1>
            <div class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>
            <br>
            <form action="" method="POST">
                <label for="Empleado">Empleado</label>
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
                <label for="fechaFalta">Fecha de incidencia</label>
                <input type="date" name="fechaFalta" id="fechaFalta" placeholder="Fecha de incidencia">
                <label for="tipoFalta">Tipo de incidencia</label>
                <select name="tipoFalta" id="tipoFalta">
                    <?php
                    $query = $con->query("SELECT*FROM tipoFalta ");
                    ?>
                    <?php
                    foreach ($query as $opciones) : ?>
                        <option value="<?php echo $opciones['idTipoFalta'] ?>"><?php echo $opciones['tipoFalta'] ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="observaciones">Observaciones</label>
                <input type="text" name="observaciones" id="observaciones" placeholder="Sea breve maximo 100 caracteres">
                <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Registrar" class="btn_Guardar"></li>
                    <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                </ul>
            </form>
        </div>
    </section>
</body>

</html>