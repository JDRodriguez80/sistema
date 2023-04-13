<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
$idAlumno = $_GET['id'];
//trayendo datos del alumno
$querry = $con->prepare("SELECT * FROM alumnos WHERE idAlumno=:idAlumno");
$querry->bindParam(':idAlumno', $idAlumno);
$querry->execute();
$alumno = $querry->fetch(PDO::FETCH_ASSOC);
$nombre = $alumno['nombre'];
$apellidoP = $alumno['primApellido'];
$apellidoM = $alumno['segApellido'];
$curp = $alumno['curp'];



//checando por vacios y sanitizando

if (!empty($_POST)) {
    //checando por campos vacios
    if (
        empty($_POST['esp1']) || empty($_POST['esp2']) || empty($_POST['esp3']) || empty($_POST['mat1']) || empty($_POST['mat2']) || empty($_POST['mat3'])
        || empty($_POST['ext1']) || empty($_POST['ext2']) || empty($_POST['ext3']) || empty($_POST['nat1']) || empty($_POST['nat2']) || empty($_POST['nat3'])
        || empty($_POST['his1']) || empty($_POST['his2']) || empty($_POST['his3']) || empty($_POST['civ1']) || empty($_POST['civ2']) || empty($_POST['civ3'])
        || empty($_POST['art1']) || empty($_POST['art2']) || empty($_POST['art3']) || empty($_POST['fis1']) || empty($_POST['fis2']) || empty($_POST['fis3'])
    ) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    }
    //sanitizando para que todos los campos sean numericos
    else {
        $esp1 = $_POST['esp1'];
        $esp2 = $_POST['esp2'];
        $esp3 = $_POST['esp3'];
        $mat1 = $_POST['mat1'];
        $mat2 = $_POST['mat2'];
        $mat3 = $_POST['mat3'];
        $ext1 = $_POST['ext1'];
        $ext2 = $_POST['ext2'];
        $ext3 = $_POST['ext3'];
        $nat1 = $_POST['nat1'];
        $nat2 = $_POST['nat2'];
        $nat3 = $_POST['nat3'];
        $his1 = $_POST['his1'];
        $his2 = $_POST['his2'];
        $his3 = $_POST['his3'];
        $civ1 = $_POST['civ1'];
        $civ2 = $_POST['civ2'];
        $civ3 = $_POST['civ3'];
        $art1 = $_POST['art1'];
        $art2 = $_POST['art2'];
        $art3 = $_POST['art3'];
        $fis1 = $_POST['fis1'];
        $fis2 = $_POST['fis2'];
        $fis3 = $_POST['fis3'];
        $ciclo = $_POST['ciclo'];
        //checando que los campos sean numericos
        if (
            is_numeric($esp1) && is_numeric($esp2) && is_numeric($esp3) && is_numeric($mat1) && is_numeric($mat2) && is_numeric($mat3) && is_numeric($ext1)
            && is_numeric($ext2) && is_numeric($ext3) && is_numeric($nat1) && is_numeric($nat2) && is_numeric($nat3) && is_numeric($his1) && is_numeric($his2) && is_numeric($his3)
            && is_numeric($civ1) && is_numeric($civ2) && is_numeric($civ3) && is_numeric($art1) && is_numeric($art2) && is_numeric($art3) && is_numeric($fis1) && is_numeric($fis2) && is_numeric($fis3)
        ) {
            //checando que los campos esten entre 0 y 10
            if (
                $esp1 >= 0 && $esp1 <= 10 && $esp2 >= 0 && $esp2 <= 10 && $esp3 >= 0 && $esp3 <= 10 && $mat1 >= 0 && $mat1 <= 10 && $mat2 >= 0 && $mat2 <= 10 && $mat3 >= 0 && $mat3 <= 10 && $ext1 >= 0 && $ext1 <= 10
                && $ext2 >= 0 && $ext2 <= 10 && $ext3 >= 0 && $ext3 <= 10 && $nat1 >= 0 && $nat1 <= 10 && $nat2 >= 0 && $nat2 <= 10 && $nat3 >= 0 && $nat3 <= 10 && $his1 >= 0 && $his1 <= 10 && $his2 >= 0 && $his2 <= 10 && $his3 >= 0 && $his3 <= 10
                && $civ1 >= 0 && $civ1 <= 10 && $civ2 >= 0 && $civ2 <= 10 && $civ3 >= 0 && $civ3 <= 10 && $art1 >= 0 && $art1 <= 10 && $art2 >= 0 && $art2 <= 10 && $art3 >= 0 && $art3 <= 10 && $fis1 >= 0 && $fis1 <= 10 && $fis2 >= 0 && $fis2 <= 10 && $fis3 >= 0 && $fis3 <= 10
            ) {
                //checando por duplicados
                $querry = $con->prepare("SELECT * FROM evaluaciones WHERE idAlumno = :idAlumno AND ciclo = :ciclo");
                $querry->bindParam(':idAlumno', $idAlumno);
                $querry->bindParam(':ciclo', $ciclo);
                $querry->execute();
                $result = $querry->fetch(PDO::FETCH_ASSOC);
                if ($result > 0) {
                    $alert = '<p class="msg_error">Ya se han registrado las calificaciones de este ciclo</p>';
                } else {
                    //insertando a la base de datos
                    $querry = $con->prepare("INSERT INTO evaluaciones (idAlumno,esp1,esp2,esp3,mat1,mat2,mat3,ext1,ext2,ext3,nat1,nat2,nat3,his1,his2,his3,civ1,civ2,civ3,art1,art2,art3,fis1,fis2,fis3,ciclo) VALUES (:idAlumno,:esp1,:esp2,:esp3,:mat1,:mat2,:mat3,:ext1,:ext2,:ext3,:nat1,:nat2,:nat3,:his1,:his2,:his3,:civ1,:civ2,:civ3,:art1,:art2,:art3,:fis1,:fis2,:fis3,:ciclo)");
                    $querry->bindParam(':idAlumno', $idAlumno);
                    $querry->bindParam(':esp1', $esp1);
                    $querry->bindParam(':esp2', $esp2);
                    $querry->bindParam(':esp3', $esp3);
                    $querry->bindParam(':mat1', $mat1);
                    $querry->bindParam(':mat2', $mat2);
                    $querry->bindParam(':mat3', $mat3);
                    $querry->bindParam(':ext1', $ext1);
                    $querry->bindParam(':ext2', $ext2);
                    $querry->bindParam(':ext3', $ext3);
                    $querry->bindParam(':nat1', $nat1);
                    $querry->bindParam(':nat2', $nat2);
                    $querry->bindParam(':nat3', $nat3);
                    $querry->bindParam(':his1', $his1);
                    $querry->bindParam(':his2', $his2);
                    $querry->bindParam(':his3', $his3);
                    $querry->bindParam(':civ1', $civ1);
                    $querry->bindParam(':civ2', $civ2);
                    $querry->bindParam(':civ3', $civ3);
                    $querry->bindParam(':art1', $art1);
                    $querry->bindParam(':art2', $art2);
                    $querry->bindParam(':art3', $art3);
                    $querry->bindParam(':fis1', $fis1);
                    $querry->bindParam(':fis2', $fis2);
                    $querry->bindParam(':fis3', $fis3);
                    $querry->bindParam(':ciclo', $ciclo);
                    $querry->execute();
                    if ($querry) {
                        $alert = '<p class="msg_save">Calificaciones registradas correctamente</p>';
                    } else {
                        $alert = '<p class="msg_error">Error al registrar las calificaciones</p>';
                    }
                }
            } else {
                $alert = '<p class="msg_error">Las calificaciones deben estar entre 0 y 10</p>';
            }
        } else {
            $alert = '<p class="msg_error">Las calificaciones deben ser numericas</p>';
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
    <title>Calificaciones </title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro3">
            <br>
            <h1>Registro de calificaciones </h1>
            <div class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>
            <br>
            <h3>Nombre del alumno: <?php echo $nombre ?> <?php echo $apellidoP ?> <?php echo $apellidoM ?></h3>
            <h3>Curp: <?php echo $curp ?></h3>
            <br>
            <form action="" method="POST">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li class="ciclo">
                        <label for="ciclo">Ciclo</label>
                        <select name="ciclo" id="ciclo">
                            <?php
                            $query = $con->query("SELECT*FROM ciclos");
                            ?>
                            <?php
                            foreach ($query as $opciones) : ?>
                                <option value="<?php echo $opciones['idCiclo'] ?>"><?php echo $opciones['ciclo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>
                </ul>
                <ul>
                    <li class="materia">
                        <h5>Español</h5>
                    </li>
                    <li>
                        <label for="primero">1° parcial</label>
                        <input type="number" name="esp1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>
                        <label for="segundo">2° parcial</label>
                        <input type="number" name="esp2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>
                        <label for="tercero">3° parcial</label>
                        <input type="number" name="esp3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>

                </ul>
                <ul>
                    <li class="materia">
                        <h5>Matematicas</h5>
                    </li>
                    <li>

                        <input type="number" name="mat1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="mat2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="mat3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>

                </ul>
                <ul>
                    <li class="materia">
                        <h5>Lengua Ext.</h5>
                    </li>
                    <li>

                        <input type="number" name="ext1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="ext2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="ext3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>

                </ul>
                <ul>
                    <li class="materia">
                        <h5>Ciencias</h5>
                    </li>
                    <li>

                        <input type="number" name="nat1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="nat2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="nat3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>

                </ul>
                <ul>
                    <li class="materia">
                        <h5>Historia</h5>
                    </li>
                    <li>

                        <input type="number" name="his1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="his2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="his3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>

                </ul>
                <ul>
                    <li class="materia">
                        <h5>Civica y Etica</h5>
                    </li>
                    <li>

                        <input type="number" name="civ1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="civ2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                    </li>
                    <li>

                        <input type="number" name="civ3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                    </li>

                </ul>
                <ul>
                    <ul>
                        <li class="materia">
                            <h5>Artes</h5>
                        </li>
                        <li>

                            <input type="number" name="art1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                        </li>
                        <li>

                            <input type="number" name="art2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                        </li>
                        <li>

                            <input type="number" name="art3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                        </li>

                    </ul>
                    <ul>
                        <li class="materia">
                            <h5>Edu. Física</h5>
                        </li>
                        <li>

                            <input type="number" name="fis1" id="primero" placeholder="0" min="0" max="10" step=".5" required>
                        </li>
                        <li>

                            <input type="number" name="fis2" id="segundo" placeholder="0" min="0" max="10" step=".5" required>
                        </li>
                        <li>

                            <input type="number" name="fis3" id="tercero" placeholder="0" min="0" max="10" step=".5" required>
                    </ul>
                </ul>

                <ul>
                    <li></li>

                    <li>
                        <br>

                        <input type="submit" value="Registrar" class="btn_Guardar">
                    </li>
                    <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                </ul>
        </div>
    </section>


</body>

</html>