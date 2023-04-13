<?php
require '../conexion.php';
session_start();
$conn = new Database();
$con = $conn->conectar();
$alert = '';
$idPersonal = $_GET['id'];
//checando si se recibio el idPersonal
/* if ($idPersonal == null) {
    header('Location: listarPersonal.php');
} */
//trayendo datos de la tabla personal
$querry = $con->prepare("SELECT * FROM personal WHERE idPersonal = :idPersonal");
$querry->bindParam(':idPersonal', $idPersonal);
$querry->execute();
$personal = $querry->fetchAll(PDO::FETCH_ASSOC);



//checando por post vacio
if (!empty($_POST)) {
    //checando por campos vacios
    if (empty($_POST['curp']) || empty($_POST['nombres']) || empty($_POST['primApellido']) || empty($_POST['idFuncion']) || empty($_POST['idSostenimiento'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {

        //checando si la curp tiene 18 caracteres
        if (strlen($_POST['curp']) == 18) {
            //checando si la curp tiene el formato correcto
            if (preg_match("/^[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]{2}$/", $_POST['curp'])) {
                //checando si el nombre tiene solo letras
                if (preg_match("/^[a-zA-Z áéíóúÁÉÍÓÚñÑ]*$/", $_POST['nombres'])) {
                    //checando si el primer apellido tiene solo letras
                    if (preg_match("/^[a-zA-Z áéíóúÁÉÍÓÚñÑ]*$/", $_POST['primApellido'])) {
                        //checando si el segundo apellido tiene solo letras
                        if (preg_match("/^[a-zA-Z áéíóúÁÉÍÓÚñÑ]*$/", $_POST['segApellido'])) {
                            //actualizando datos
                            $querry = $con->prepare("UPDATE personal SET nombres=:nombres, primApellido=:primApellido, segApellido=:segApellido, fdn=:fdn, ingresoSep=:fdi, ingresoCtt=:fdictt, noPlaza=:noPlaza, idFuncion=:idFuncion, idSostenimiento=:idSostenimiento, curp=:curp, rfc=:rfc   WHERE idPersonal = :idPersonal");
                            $querry->bindParam(':nombres', $_POST['nombres']);
                            $querry->bindParam(':primApellido', $_POST['primApellido']);
                            $querry->bindParam(':segApellido', $_POST['segApellido']);
                            $querry->bindParam(':fdn', $_POST['fdn']);
                            $querry->bindParam(':fdi', $_POST['fdi']);
                            $querry->bindParam(':fdictt', $_POST['fdictt']);
                            $querry->bindParam(':noPlaza', $_POST['noPlaza']);
                            $querry->bindParam(':idFuncion', $_POST['idFuncion']);
                            $querry->bindParam(':idSostenimiento', $_POST['idSostenimiento']);
                            $querry->bindParam(':curp', $_POST['curp']);
                            $querry->bindParam(':rfc', $_POST['rfc']);
                            $querry->bindParam(':idPersonal', $idPersonal);
                            $querry->execute();
                            $alert = '<p class="msg_save">Personal actualizado correctamente</p>';
                        } else {
                            $alert = '<p class="msg_error">El segundo apellido solo debe contener letras</p>';
                        }
                    } else {
                        $alert = '<p class="msg_error">El primer apellido solo debe contener letras</p>';
                    }
                } else {
                    $alert = '<p class="msg_error">El nombre apellido solo debe contener letras</p>';
                }
            } else {
                $alert = '<p class="msg_error">La curp no tiene el formato correcto</p>';
            }
        } else {
            echo "La curp debe tener 18 caracteres";
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
    <?php ?>
    <title>Document</title>
</head>

<body>

    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <br>
            <h1>Editar Personal</h1>
            <br>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post">
                <h3>Datos personales</h3>
                <?php foreach ($personal as $dataP) : ?>
                    <ul>
                        <li>
                            <label for="nombre">Nombres</label>
                            <input type="text" name="nombres" id="nombre" value="<?php echo $dataP['nombres'] ?>">
                        </li>
                        <li>
                            <label for="primApellido">Primer apellido</label>
                            <input type="text" name="primApellido" id="primApellido" value="<?php echo $dataP['primApellido'] ?>">
                        </li>
                        <li>
                            <label for="segApellido">Segundo apellido</label>
                            <input type="text" name="segApellido" id="segApellido" value="<?php echo $dataP['segApellido'] ?>">
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label for="fdn">Fecha de nacimiento</label>
                            <input type="date" name="fdn" id="fdn" value="<?php echo $dataP['fdn'] ?>">
                        </li>
                        <li>
                            <label for="fdi">Fecha de ingreso a SEP</label>
                            <input type="date" name="fdi" id="fdi" value="<?php echo $dataP['ingresoSep'] ?>">
                        </li>
                        <li>
                            <label for="fdictt">Fecha de ingreso a C.T </label>
                            <input type="date" name="fdictt" id="fdictt" value="<?php echo $dataP['ingresoCtt'] ?>">
                        </li>
                        <li>
                            <label for="noPlaza">Numero de plaza</label>
                            <input type="text" name="noPlaza" id="noPlaza" value="<?php echo $dataP['noPlaza'] ?>">
                        </li>
                        <li>
                            <label for="funcion">Función:</label>
                            <select name="idFuncion" id="funcion">
                                <?php
                                $funcionFo = $dataP['idFuncion'];
                                if ($funcionFo == 1) {; ?>
                                    <option value='1' selected>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>
                                <?php } elseif ($funcionFo == 2) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2' selected>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 3) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3' selected>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 4) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4' selected>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 5) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5' selected>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 6) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6' selected>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 7) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7' selected>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 8) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8' selected>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 9) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9' selected>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 10) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10' selected>Intendencia</option>
                                    <option value='11'>Directivo</option>

                                <?php } elseif ($funcionFo == 11) {; ?>
                                    <option value='1'>Docente frente a grupo</option>
                                    <option value='2'>Docente sin grupo</option>
                                    <option value='3'>Docente Tecnología</option>
                                    <option value='4'>Psicología</option>
                                    <option value='5'>Medicina</option>
                                    <option value='6'>Terapista Físico</option>
                                    <option value='7'>Comunicación</option>
                                    <option value='8'>Niñera</option>
                                    <option value='9'>Secretariado</option>
                                    <option value='10'>Intendencia</option>
                                    <option value='11' selected>Directivo</option>
                                <?php }; ?>
                            </select>
                        </li>
                        <li>
                            <label for="sostenimiento">Sostenimiento</label>
                            <select name="idSostenimiento" id="idSostenimiento">
                                <?php
                                $sostenimientoFo = $dataP['idSostenimiento'];
                                if ($sostenimientoFo == 1) {; ?>
                                    <option value='1' selected>Federal</option>
                                    <option value='2'>Federalizado(estatal)</option>
                                    <option value='3'>Contrato</option>
                                <?php } elseif ($sostenimientoFo == 2) {; ?>
                                    <option value='1'>Federal</option>
                                    <option value='2' selected>Federalizado(estatal)</option>
                                    <option value='3'>Contrato</option>
                                <?php } elseif ($sostenimientoFo == 3) {; ?>
                                    <option value='1'>Federal</option>
                                    <option value='2'>Federalizado(estatal)</option>
                                    <option value='3' selected>Contrato</option>
                                <?php }; ?>
                            </select>
                        </li>
                        <li>
                            <label for="curp">CURP:</label>
                            <input type="text" name="curp" id="curp" value="<?php echo $dataP['curp'] ?>">
                        </li>
                        <li><label for="rfc">RFC</label>
                            <input type="text" name="rfc" id="rfc" value="<?php echo $dataP['rfc'] ?>">
                        </li>
                        <br>
                        <br>
                    </ul>
                    <ul>
                        <li><input type="submit" value="Actualizar" class="btn_Guardar"></li>
                        <li><input type="button" onclick="window.location.href='listarPersonal.php';" value="Salir" class="btn_Danger"></li>
                    </ul>
            </form>
        <?php endforeach; ?>
        </div>

    </section>

</body>

</html>