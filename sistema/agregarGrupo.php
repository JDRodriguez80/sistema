<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

if (!empty($_POST)) {
    $alert = "";
    if (
        empty($_POST['grupo'])
    ) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {
        
        $grupo = $_POST['grupo'];
        $secion = $_POST['seccion'];
        // checando por duplicado
        $querry=$con->prepare("SELECT * FROM grupo where grupo=:grupo");
        $querry->bindParam(":grupo",$grupo);
        $querry->execute();

        if ($querry->rowCount() > 0) {
            $alert = '<p class="msg_error"> El grupo ya existe </p>';
        } else {
            $querry = $con->prepare("INSERT INTO `grupo` (`grupo`, `idSeccion`) VALUES (:grupo, :seccion)");
            $querry->bindParam(':grupo', $grupo);
            $querry->bindParam(':seccion', $secion);
            $querry->execute();
            if ($querry) {
                $alert = '<p class="msg_success"> grupo agregado de manera correcta. </p>';
            } else {
                $alert = '<p class="msg_error"> Fallo en la inserción, favor de checar la información. </p>>';
            }
        }
    }
}

?>

<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../sistema/css/style.css">
    <title>Grupo</title>
</head>

<body>
    <!-- todo-me formulario para adicion del grupo-->
    <?php include '../sistema/includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Agregar Grupo</h1>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ?></div>
            <form action="" method="post">
                <ul>
                    <h5>Datos del Grupo</h5>
                    <label for="grupo">Grupo:</label>
                    <input type="text" name="grupo" id="grupo" placeholder="Nombre del grupo" required>
                    <label for="seccion">Seccion:</label>
                    <select name="seccion" id="seccion">
                        <?php
                        $consulta= $con->prepare("SELECT * FROM seccion");
                        $consulta->execute();
                        $ejecutar = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($ejecutar as $opciones) : ?>
                            <option value="<?php echo $opciones['idSeccion'] ?>"><?php echo $opciones['seccion'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <li></li>
                    <li></li>
                    <ul>
                        <li><input type="submit" value="Crear Grupo" class="btn_Guardar"></li>
                        <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                    </ul>

                </ul>
            </form>
        </div>
    </section>
</body>

</html>