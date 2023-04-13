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
//trayendo datos
$query = $con->prepare("SELECT * FROM tipoPago where idTipoPago=:id");
$query->bindParam(":id", $_GET['id']);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
//checando por post
if (!empty($_POST)) {
    //checando por campos vacios
    if (empty($_POST['nombre']) || empty($_POST['descripcion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    }
    //sanitizando datos
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];


    //insertando datos
    $query = $con->prepare("Update tipoPago set nombrePago=:nombre, descripcion=:descripcion where idTipoPago=:id");
    $query->bindParam(":nombre", $nombre);
    $query->bindParam(":descripcion", $descripcion);
    $query->bindParam(":id", $_GET['id']);
    $query->execute();
    if ($query) {
        $alert = '<p class="msg_save">Tipo de pago registrado correctamente</p>';
    } else {
        $alert = '<p class="msg_error">Error al registrar el tipo de pago</p>';
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
            <h1>Editar Tipo Pago</h1>
            <div class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>
            <form action="" method="post">

                <?php foreach ($result as $data) { ?>

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $data['nombrePago'] ?>">

                    <label for="descripcion">Descripcion</label>
                    <input type="text" name="descripcion" id="descripcion" value="<?php echo $data['descripcion'] ?>">
                    <br>
                    <ul style=" align-items: flex-end;">
                        <li><input type="submit" value="Editar" class="btn_Editar"></li>
                        <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                    <?php } ?>
                    </ul>
            </form>
        </div>
    </section>
</body>

</html>