<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$idPermiso = $_GET['id'];
$alert = '';
//igualando los datos de la base de datos a los campos del formulario
$query = $con->prepare("SELECT * FROM permisos WHERE idPermiso=$idPermiso");
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

//checar por vacios
if (!empty($_POST)) {
    if (empty($_POST['idPersonal']) || empty($_POST['tipoPermiso']) || empty($_POST['fechaincio']) || empty($_POST['fechafin']) || empty($_POST['fechaAut']) || empty($_POST['observaciones']) || empty($_POST['tipoEmpleado'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        $idPersonal = $_POST['idPersonal'];
        $tipoPermiso = $_POST['tipoPermiso'];
        $fechaincio = $_POST['fechaincio'];
        $fechafin = $_POST['fechafin'];
        $fechaAut = $_POST['fechaAut'];
        $observaciones = $_POST['observaciones'];
        $tipoEmpleado = $_POST['tipoEmpleado'];

        if ($tipoPermiso == 4) {
            //checando por permisos en ese periodo de tiempo del mismo tipo de empleados si se trata de permisos económicos
            $querry = $con->prepare("SELECT * FROM permisos WHERE ($fechaincio BETWEEN fechaInicio AND fechafin
        OR  $fechafin BETWEEN fechaInicio AND fechafin
        OR fechaInicio BETWEEN $fechaincio AND $fechafin
         )AND tipoEmpleado=$tipoEmpleado ");

            $querry->execute();
            $result = $querry->fetch(PDO::FETCH_ASSOC);
            if ($result >= 2) {
                $alert = '<p class="msg_error">No se puede registrar el permiso, ya hay 2 permisos en ese periodo de tiempo</p>';
            }
        }
        //checando por duplicados
        $query = $con->prepare("SELECT * FROM permisos WHERE idPersonal=$idPersonal AND tipoPermiso=$tipoPermiso AND fechaInicio=$fechaincio AND fechafin=$fechafin");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            $alert = '<p class="msg_error">El permiso ya existe</p>';
        } else {
            //insertando datos
            $query = $con->prepare("UPDATE permisos SET idPersonal=:idPersonal, tipoPermiso=:tipoPermiso, fechaInicio=:fechaInicio, fechafin=:fechafin, fechaAu=:fechaAut, observaciones=:observaciones, tipoEmpleado=:tipoEmpleado WHERE idPermiso=$idPermiso");
            $query->bindParam(":idPersonal", $idPersonal);
            $query->bindParam(":tipoPermiso", $tipoPermiso);
            $query->bindParam(":fechaInicio", $fechaincio);
            $query->bindParam(":fechafin", $fechafin);
            $query->bindParam(":fechaAut", $fechaAut);
            $query->bindParam(":observaciones", $observaciones);
            $query->bindParam(":tipoEmpleado", $tipoEmpleado);
            $query->execute();
            if ($query) {
                $alert = '<p class="msg_save">Permiso registrado correctamente</p>';
            } else {
                $alert = '<p class="msg_error">Error al registrar el permiso</p>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Editar permisos</h1>

            <div class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>
            <form action="" method="post">
                <label for="Empleado">Empleado</label>
                <select name="idPersonal" id="idPersonal">
                    <?php $querry = $con->prepare("SELECT `nombres`,`primApellido`,`segApellido` FROM personal WHERE idPersonal=:idPersonal");
                    $querry->bindParam(":idPersonal", $resultado['idPersonal']);
                    $querry->execute();
                    $nombre = $querry->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <option value="<?php echo $resultado['idPersonal']; ?>"><?php echo $nombre['nombres'] . " " . $nombre['primApellido'] . " " . $nombre['segApellido']; ?></option>
                </select>
                <label for="tipoPermiso">Tipo de permiso</label>
                <select name="tipoPermiso" id="tipoPermiso">

                    <?php if ($resultado['tipoPermiso'] == 1) { ?>
                        <option value="1" selected>Personal</option>
                        <option value="2">Incapacidad</option>
                        <option value="3">Sindical</option>
                        <option value="4">Económico</option>
                    <?php } elseif ($resultado['tipoPermiso'] == 2) { ?>
                        <option value="1">Personal</option>
                        <option value="2" selected>Incapacidad</option>
                        <option value="3">Sindical</option>
                        <option value="4">Económico</option>
                    <?php } elseif ($resultado['tipoPermiso'] == 3) { ?>
                        <option value="1">Personal</option>
                        <option value="2">Incapacidad</option>
                        <option value="3" selected>Sindical</option>
                        <option value="4">Económico</option>
                    <?php } elseif ($resultado['tipoPermiso'] == 4) { ?>
                        <option value="1">Personal</option>
                        <option value="2">Incapacidad</option>
                        <option value="3">Sindical</option>
                        <option value="4" selected>Económico</option>

                    <?php } ?>
                </select>
                <label for="fechaincio">Fecha de inicio</label>
                <input type="date" name="fechaincio" id="fechaincio" value="<?php echo $resultado['fechaInicio'] ?>">
                <label for="fechafin">Fecha de fin</label>
                <input type="date" name="fechafin" id="fechafin" value="<?php echo $resultado['fechafin'] ?>">
                <label for="fechaAut">Fecha de autorización</label>
                <input type="date" name="fechaAut" id="fechaAut" value="<?php echo $resultado['fechaAu'] ?>">
                <label for="observaciones">Observaciones</label>
                <input type="text" name="observaciones" id="observaciones" value="<?php echo $resultado['observaciones'] ?>">
                <label for="tipoEmpleado">Tipo de empleado</label>
                <select name="tipoEmpleado" id="tipoEmpleado">
                    <?php if ($resultado['tipoEmpelado'] == 1) { ?>
                        <option value="1" selected>Administrativo</option>
                        <option value="2">Docente</option>
                    <?php } else { ?>
                        <option value="1">Administrativo</option>
                        <option value="2" selected>Docente</option>
                    <?php } ?>
                </select>

                <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Editar" class="btn_secondary-color-dark"></li>
                    <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                </ul>
            </form>
        </div>
    </section>


</body>

</html>