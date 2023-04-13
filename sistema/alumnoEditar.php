<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

if (!empty($_POST)) {
    $result = null;
    $result = "";
    $alert = '';


    if (
        empty($_POST['nombre']) || empty($_POST['primApellido']) || empty($_POST['fdn']) || empty($_POST['curp']) || empty($_POST['discapacidad']) || empty($_POST['grupo'])
    ) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {


        $llave = true;
        $alumnoid = $_POST['AlumnoId'];
        $nombre = $_POST['nombre'];
        $primApellido = $_POST['primApellido'];
        $segApellido = $_POST['segApellido'];
        $fdn = $_POST['fdn'];
        $curp = $_POST['curp'];
        $sexo = $_POST['sexo'];
        $discapacidad = $_POST['discapacidad'];
        $telefono = $_POST['telefono'];
        $alergias = $_POST['alergias'];
        $tipoSangre = $_POST['tiposangre'];
        $desayunos = $_POST['desayuno'];
        $grupo = $_POST['grupo'];
        $estatura = $_POST['estatura'];
        $peso = $_POST['Peso'];
        $calle = $_POST['calle'];
        $numero = $_POST['numero'];
        $idEstado = $_POST['estado'];
        $idMunicipio = $_POST['municipio'];
        $colonia2 = $_POST['colonia'];
        $codigo = $_POST['codigo'];
        $colonia = "";
        //checando por el id del codigo postal
        // var_dump($idCp);
        //checando por duplicados
        $query = $con->prepare("SELECT*FROM alumnos WHERE curp=?");
        $query->bindParam(1, $curp);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $idCp  = $colonia2;

        $idCodigo;

        $consulta1 = $con->prepare("SELECT * FROM `codigopostal`WHERE idCp =?");
        $consulta1->bindParam(1, $idCp);
        $consulta1->execute();
        $ejecutar1 = $consulta1->fetchAll(PDO::FETCH_ASSOC);
        foreach ($ejecutar1 as $result) {
            $colonia = $result['Colonia'];
        }



        //Se imprimen las variables solo para validar seguimiento, eliminar una vez revisado

        //exit;
        //reemplazar por update

        $query = $con->prepare("UPDATE alumnos SET nombre=?, primApellido=?, segApellido=?, fdn=?, curp=?, sexo=?, idDiscapacidad=?, telefono=?, alergias=?, idTipoSange=?, desayunos=?, idGrupo=?, estatura=?, peso=?, calle=?, numero=?, idCodigo=?, idEstado=?, idMunicipio=?, Colonia=? WHERE idAlumno=?");
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $primApellido);
        $query->bindParam(3, $segApellido);
        $query->bindParam(4, $fdn);
        $query->bindParam(5, $curp);
        $query->bindParam(6, $sexo);
        $query->bindParam(7, $discapacidad);
        $query->bindParam(8, $telefono);
        $query->bindParam(9, $alergias);
        $query->bindParam(10, $tipoSangre);
        $query->bindParam(11, $desayunos);
        $query->bindParam(12, $grupo);
        $query->bindParam(13, $estatura);
        $query->bindParam(14, $peso);
        $query->bindParam(15, $calle);
        $query->bindParam(16, $numero);
        $query->bindParam(17, $codigo);
        $query->bindParam(18, $idEstado);
        $query->bindParam(19, $idMunicipio);
        $query->bindParam(20, $colonia);
        $query->bindParam(21, $alumnoid);
        $query->execute();


        if ($query->rowCount() > 0) {

            $llave = false;
            $alert = '<p class="msg_success"> Alumno actualizado de manera correcta. </p>';
            header("LOCATION:ListarAlumnos.php");
            $result = null;
        } else {
            $alert = '<p class="msg_error"> Fallo en la actualización, favor de checar la información. </p>>';
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
    <link rel="stylesheet" href="../sistema/css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Editar Alumno</title>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section id="container">

        <div class="form-Registro2">
            <h1>Editar Alumno</h1>

            <div class="alert"><?php echo isset($alert) ? $alert : '' ?> </div>

            <form action="" method="post">

                <ul>
                    <h5>Datos Personales</h5>
                    <?php
                    //llenando formularios con datos de base dee datos
                    //definiendo las variables

                    $alumno = $_GET['id'];
                    $idAlumno = '';
                    $nombreAlumno = '';
                    $primAp = '';
                    $segAp = '';
                    $fdnAlumno = '';
                    $curpAlumno = '';
                    $sexoAlumno = '';
                    $discapacidadAlumno = '';
                    $telefonoAlumno = '';
                    $alergiasAlumno = '';
                    $tipoSangreAlumno = '';
                    $desayunosAlumno = '';
                    $grupoAlumno = '';
                    $estaturaAlumno = '';
                    $pesoAlumno = '';
                    $idCpAlumno = '';
                    $query = $con->prepare("SELECT * FROM alumnos where idAlumno=$alumno");
                    $query->execute();
                    $ejecutar = $query->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($ejecutar as $opciones) :
                        $nombreAlumno = $opciones['nombre'];
                        $primAp = $opciones['primApellido'];
                        $segAp = $opciones['segApellido'];
                        $fdnAlumno = $opciones['fdn'];
                        $curpAlumno = $opciones['curp'];
                        $sexoAlumno = $opciones['sexo'];
                        $discapacidadAlumno = $opciones['idDiscapacidad'];
                        $telefonoAlumno = $opciones['telefono'];
                        $alergiasAlumno = $opciones['alergias'];
                        $tipoSangreAlumno = $opciones['idTipoSange'];
                        $desayunosAlumno = $opciones['desayunos'];
                        $grupoAlumno = $opciones['idGrupo'];
                        $estaturaAlumno = $opciones['estatura'];
                        $pesoAlumno = $opciones['peso'];
                        $calleAlumno = $opciones['calle'];
                        $numeroAlumno = $opciones['numero'];


                    ?>

                    <?php endforeach; ?>

                    <label for="nombres">Nombres:</label>
                    <input type="hidden" name="AlumnoId" id="AlumnoId" value="<?php echo $alumno ?>">
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombreAlumno; ?>" required>

                    <label for="primApellido">Primer Apellido:</label>
                    <input type="text" name="primApellido" id="primApellido" value="<?php echo $primAp; ?>" required>
                    <label for="segApellido">Segundo Apellido:</label>
                    <input type="text" name="segApellido" id="segApellido" value="<?php echo $segAp; ?>">
                    <li>
                        <label for=" fdn">Fecha de Nacimiento:</label>
                        <input type="date" name="fdn" id="fdn" value="<?php echo $fdnAlumno; ?>" required>
                    </li>
                    <li>
                        <label for="curp">CURP:</label>
                        <input type="text" name="curp" id="curp" value="<?php echo $curpAlumno; ?>" required>
                    </li>
                    <li>
                        <label for="sexo">Sexo:</label>
                        <select name="sexo" id="sexo" required>
                            <option value="M">M</option>
                            <option value="H">H</option>
                        </select>
                    </li>
                    <li>
                        <label for="discapacidad">Discapacidad:</label>
                        <select name="discapacidad" id="discapacidad">
                            <?php
                            //include_once "../conexion.php";
                            $consulta = "SELECT * FROM discapacidad";
                            $query = $con->prepare($consulta);
                            $query->execute();
                            $ejecutar = $query->fetchAll(PDO::FETCH_ASSOC);

                            ?>
                            <?php
                            foreach ($ejecutar as $opciones) : ?>
                                <option value="<?php echo $opciones['idDiscapacidad'] ?>"><?php echo $opciones['Discapacidad'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>
                    <li>
                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" value="<?php echo $telefonoAlumno; ?>" required>
                    </li>
                    <li>
                        <label for="alergias">Alergias:</label>
                        <input type="text" name="alergias" id="alergias" value="<?php echo $alergiasAlumno; ?>">
                    </li>
                    <li>
                        <label for="estatura">Estatura:</label>
                        <input type="text" name="estatura" id="estatura" value="<?php echo $estaturaAlumno; ?>">
                    </li>
                    <li>
                        <label for="Peso">Peso:</label>
                        <input type="text" name="Peso" id="Peso" value="<?php echo $pesoAlumno; ?>">
                    </li>
                    <li>
                        <label for="tiposangre">Tipo de sangre:</label>
                        <select name="tiposangre" id="tiposangre">
                            <?php
                            //include_once "../conexion.php";
                            $consulta = "SELECT * FROM tiposangre";
                            $query = $con->prepare($consulta);
                            $query->execute();
                            $ejecutar = $query->fetchAll(PDO::FETCH_ASSOC);

                            ?>
                            <?php
                            foreach ($ejecutar as $opciones) : ?>
                                <option value="<?php echo $opciones['idTipo'] ?>"><?php echo $opciones['tipo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>
                    <li>
                        <label for="desayuno">¿Toma Desayuno?</label>
                        <select name="desayuno" id="desayuno" required>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </li>
                    <li>
                        <label for="grupo">Grupo:</label>
                        <select name="grupo" id="grupo">
                            <?php
                            //include_once "../conexion.php";
                            $consulta = "SELECT * FROM grupo";
                            $query = $con->prepare($consulta);
                            $query->execute();
                            $ejecutar = $query->fetchAll(PDO::FETCH_ASSOC);

                            ?>
                            <?php
                            foreach ($ejecutar as $opciones) : ?>
                                <option value="<?php echo $opciones['idGrupo'] ?>"><?php echo $opciones['grupo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>

                    <br>
                    <h5>Dirección</h5>
                    <li>
                        <label for="calle">Calle:</label>
                        <input type="text" name="calle" id="calle" value="<?php echo $calleAlumno; ?>">
                    </li>
                    <li>
                        <label for="numero">Número:</label>
                        <input type="text" name="numero" id="numero" value=<?php echo $numeroAlumno; ?>>
                    </li>
                    <li>

                        <label for="codigo">Código Postal:</label>
                        <input type="text" name="codigo" id="codigo" placeholder="00000" required oninput="consultaCP(this.value)">
                    </li>
                    <li></li>
                    <li></li>
                    <li></li>


                    <li>
                        <label for="estado">Estado:</label>

                        <select name="estado" id="estado">
                            <?php
                            // include_once "../conexion.php";
                            $consulta = "SELECT * FROM estados where idEstado=28";
                            $query = $con->prepare($consulta);
                            $query->execute();
                            $ejecutar = $query->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php
                            foreach ($ejecutar as $opciones) : ?>

                                <option value="<?php echo $opciones['idEstado'] ?>"><?php echo $opciones['Estado'] ?></option>

                            <?php endforeach; ?>
                        </select>
                    </li>
                    <li>
                        <label for="municipio">Municipio:</label>

                        <select name="municipio" id="municipio">
                            <?php
                            //include_once "conexion.php";
                            echo $idEstado;
                            $consulta = "SELECT * FROM municipio where idEstado=28";
                            $query = $con->prepare($consulta);
                            $query->execute();
                            $ejecutar = $query->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php
                            foreach ($ejecutar as $opciones) : ?>
                                <option value="<?php echo $opciones['idMunicipio'] ?>"><?php echo $opciones['municipio'] ?></option>

                            <?php endforeach; ?>
                        </select>

                    </li>
                    <li>
                        <div id="Col">
                            <label for="colonia">Colonia:</label>
                            <select name="colonia" id="colonia" onselect="idCpxColonia(this.Selection)">

                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </li>
                    <li>

                    </li>
                    <li>
                    </li>

                    <li><input type="submit" value="Editar Alumno" class="btn_secondary-color-dark"></li>
                </ul>

            </form>
        </div>


    </section>
    <!-- Script para indicar las colonias de un codigo postal-->
    <script type="text/javascript">
        function consultaCP(cp) {
            var conexion;
            if (cp == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                conexion = new XMLHttpRequest();
            }
            conexion.onreadystatechange = function() {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    document.getElementById("colonia").innerHTML = conexion.responseText;
                }
            }
            conexion.open("GET", "codigopostal.php?cp=" + cp, true);
            conexion.send();
        }

        function idCpxColonia(colonia) {
            var conexion2;
            if (colonia == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                conexion = new XMLHttpRequest();
            }
            conexion.onreadystatechange = function() {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    // document.getElementById("codigoPostalID").innerHTML=conexion.responseText;
                }
            }
            conexion2.open("GET", "idCPporColonia.php?colonia=" + colonia, true);
            conexion2.send();
        }
    </script>


    <?php include "includes/footer.php"; ?>
</body>

</html>