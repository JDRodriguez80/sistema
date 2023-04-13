<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$grupoId = $_GET['id'];
if (!empty($_POST)) {
    $alert = "";
    if (
        empty($_POST['grupo'])
    ) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {
        include_once "../conexion.php";
        $grupo = $_POST['grupo'];
        $idPersonal=$_POST['idPersonal'];
       
        
            $querry = $con->prepare("UPDATE `grupo` SET idPersonal=:idPersonal WHERE `idGrupo` = :grupoId");
            $querry->bindParam(':idPersonal', $idPersonal);
            $querry->bindParam(':grupoId', $grupoId);
            $querry->execute();

            if ($querry) {
                $alert = '<p class="msg_success"> grupo asignado de manera correcta. </p>';
            } else {
                $alert = '<p class="msg_error"> Fallo en la asignación, favor de checar la información. </p>>';
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
    <title>Editar Grupo</title>
</head>

<body>

    <?php include '../sistema/includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Editar Grupo</h1>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ?></div>
            <form action="" method="post">
                <ul>
                    <h5>Datos del Grupo</h5>
                    <label for="grupo">Grupo:</label>
                    <?php
                    $querry = $con->prepare("SELECT * FROM grupo where idGrupo=:grupoId");
                    $querry->bindParam(':grupoId', $grupoId);
                    $querry->execute();
                    $ejecutar = $querry->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <?php
                    foreach ($ejecutar as $valores) : ?>
                        <input type="text" name="grupo" id="grupo" value="<?php echo $valores['grupo'] ?>">
                    <?php endforeach; ?>
                    <label for="seccion">Seccion:</label>
                    <select name="idPersonal" id="idPersonal">
                        <?php
                        $consulta = $con->prepare("SELECT * FROM personal ");
                        $consulta->execute();
                        $ejecutar = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($ejecutar as $opciones) : ?>
                            <option value="<?php echo $opciones['idPersonal'] ?>"><?php echo $opciones['nombres'] . " " . $opciones['primApellido'] . " " . $opciones['segApellido']; ?></option>

                        <?php
                           
                        endforeach; ?>
                    </select>
                    <li></li>
                    <li></li>
                    <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Asignar Grupo" class="btn_Guardar"></li>
                    <li><input type="button" onclick="window.location.href='asignarPersonal.php';" value="Salir" class="btn_Danger"></li>
                    </ul>
                </ul>
            </form>
        </div>
    </section>
</body>

</html>