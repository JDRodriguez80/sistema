<?php
session_start();

require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
//checando por privilegios de usuario 
$nivel = $_SESSION['nivelUsuario'];

if ($nivel != 1 || $nivel != 2) {
    header('location index.php');
}
//checando por post
if (!empty($_POST)) {
    //checando por campos vacios
    if (empty($_POST['nombre']) || empty($_POST['descripcion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    }
    //sanitizando datos
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    //checando por duplicados
    $query = $con->prepare("SELECT * FROM tipoPago WHERE nombrePago='$nombre'");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result > 0) {
        $alert = '<p class="msg_error">El tipo de pago ya existe</p>';
    } else {
        //insertando datos
        $query = $con->prepare("INSERT INTO tipoPago(nombrePago,descripcion) values(:nombre,:descripcion)");
        $query->bindParam(":nombre", $nombre);
        $query->bindParam(":descripcion", $descripcion);
        $query->execute();
        if ($query) {
            $alert = '<p class="msg_save">Tipo de pago registrado correctamente</p>';
        } else {
            $alert = '<p class="msg_error">Error al registrar el tipo de pago</p>';
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
    <title>Tipo de pagos</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Agregar un tipo de pago</h1>
            <div class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>
            <form action="" method="post">
                <ul>
                    <li>
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre">
                    </li>
                    <li>
                        <label for="descripcion">Descripcion</label>
                        <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion">
                    </li>
                </ul>
                <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Registrar" class="btn_Guardar"></li>
                    <li><input type="button" onclick="window.location.href='listarTipoPago.php';" value="Salir" class="btn_Danger"></li>
                </ul>
            </form>
        </div>
    </section>
</body>

</html>