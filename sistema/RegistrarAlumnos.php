<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();


if (!empty($_POST)) {
    $result = null;
    $result = "";
    $alert = '';

    //checando por vacios
    if (
        empty($_POST['nombre']) || empty($_POST['primApellido']) || empty($_POST['fdn']) || empty($_POST['curp']) || empty($_POST['discapacidad']) || empty($_POST['grupo'])
    ) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    }
    //checando por longitud del curp
    if ($_POST['curp'] == "" || strlen($_POST['curp']) != 18) {
        $alert = '<p class="msg_error"> El curp debe de tener 18 caracteres</p>';
    }
    //chacando por formato del curp
    $patron = "/^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[0-9]{2}$/";
    if (!preg_match($patron, $_POST['curp'])){
        $alert = '<p class="msg_error"> El CURP es inválido</p>';    
    } else{
    //checando por longitud del telefono
    if (strlen($_POST['telefono']) != 10) {
        $alert = '<p class="msg_error"> El teléfono debe contener 10 numeros </p>';
    } 
        //asiognando valores a variables
    else {
        $llave = true;
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

        //checando por duplicados
        $sql = $con->prepare("SELECT*FROM alumnos WHERE curp=:curp");
        $sql->bindParam(':curp', $curp);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        $result = $sql->fetch();
        if ($result > 0) {

            $alert = '<p class="msg_error"> El alumno ya existe </p>';
        } else {
            $idCp  = $colonia2;
            $idCodigo;
            $sql = $con->prepare("SELECT * FROM `codigopostal` WHERE idCp ='$idCp'");
            $ejecutar = $sql->fetchAll();
            foreach ($ejecutar as $result) {
                $colonia = $result['Colonia'];
            }
            $stmt = $con->prepare("CALL insertarAlumnos(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )");
            $stmt->bindParam(1, $nombre);
            $stmt->bindParam(2, $primApellido);
            $stmt->bindParam(3, $segApellido);
            $stmt->bindParam(4, $fdn);
            $stmt->bindParam(5, $curp);
            $stmt->bindParam(6, $sexo);
            $stmt->bindParam(7, $discapacidad);
            $stmt->bindParam(8, $telefono);
            $stmt->bindParam(9, $alergias);
            $stmt->bindParam(10, $tipoSangre);
            $stmt->bindParam(11, $desayunos);
            $stmt->bindParam(12, $grupo);
            $stmt->bindParam(13, $estatura);
            $stmt->bindParam(14, $peso);
            $stmt->bindParam(15, $colonia);
            $stmt->bindParam(16, $numero);
            $stmt->bindParam(17, $calle);
            $stmt->bindParam(18, $idEstado);
            $stmt->bindParam(19, $idMunicipio);
            $stmt->bindParam(20, $idCp);
            $stmt->execute();
            if ($stmt) {
                $alert = '<p class="msg_success"> Alumno agregado de manera correcta. </p>';
                $llave = false;
                $result = null;
                echo '<script type="text/javascript">location.reload(false);</script>';
                header("LOCATION:ListarAlumnos.php");
            } else {
                $alert = '<p class="msg_error"> Fallo en la inserción, favor de checar la información. </p>>';
            }
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
    <link rel="stylesheet" href="../sistema/css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Registrar Alumno</title>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section id="container">

        <div class="form-Registro2">
            <h1>Registrar Alumno</h1>

            <div class="alert"><?php echo isset($alert) ? $alert : '' ?> </div>

            <form action="" method="post">

                <ul>
                    <h5>Datos Personales</h5>
                    <label for="nombres">Nombres:</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" required>

                    <label for="primApellido">Primer Apellido:</label>
                    <input type="text" name="primApellido" id="primApellido" placeholder="Primer Apellido" required>
                    <label for="segApellido">Segundo Apellido:</label>
                    <input type="text" name="segApellido" id="segApellido" placeholder="Segundo Apellido">
                    <li>
                        <label for="fdn">Fecha de Nacimiento:</label>


                        <input type="date" max="<?php echo date('d-m-Y') ?>" name="fdn" id="fdn" placeholder="Fecha de Nacimiento" required>
                    </li>
                    <li>
                        <label for="curp">CURP:</label>
                        <input size="18" maxlength="18" minlength="18" type="text" name="curp" id="curp" placeholder="CURP" required>
                    </li>
                    <li>
                        <label for=sexo">Sexo:</label>
                        <select name="sexo" id="sexo" required>
                            <option value="M">M</option>
                            <option value="H">H</option>
                        </select>
                    </li>
                    <li>
                        <label for="discapacidad">Discapacidad:</label>
                        <select name="discapacidad" id="discapacidad">
                            <?php
                            $query = $con->query("SELECT*FROM discapacidad");
                            $ejecutar = $query->fetchAll();
                            ?>
                            <?php
                            foreach ($ejecutar as $opciones) : ?>
                                <option value="<?php echo $opciones['idDiscapacidad'] ?>"><?php echo $opciones['Discapacidad'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>
                    <li>
                        <label for="telefono">Teléfono:</label>
                        <input size="10" maxlength="10" minlength="10" type="text" name="telefono" id="telefono" placeholder="868-000-00-00" onkeyup="check(this)" required>
                    </li>
                    <li>
                        <label for="alergias">Alergias:</label>
                        <input type="text" name="alergias" id="alergias" placeholder="Alergias">
                    </li>
                    <li>
                        <label for="estatura">Estatura:</label>
                        <input size="3" maxlength="3" type="text" name="estatura" id="estatura" placeholder="Estatura" onkeyup="check(this)">
                    </li>
                    <li>
                        <label for="Peso">Peso:</label>
                        <input size="3" maxlength="3" type="text" name="Peso" id="Peso" placeholder="Peso" onkeyup="check(this)">
                    </li>
                    <li>
                        <label for="tiposangre">Tipo de sangre:</label>
                        <select name="tiposangre" id="tiposangre">
                            <?php
                            $sql = $con->prepare("SELECT*FROM tiposangre");
                            $sql->execute();
                            $ejecutar = $sql->fetchAll();
                            ?>
                            <?php
                            foreach ($ejecutar as $opciones) : ?>
                                <option value="<?php echo $opciones['idTipo'] ?>"><?php echo $opciones['tipo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>
                    <li>
                        <label for="desayuno">¿Toma Desayuno?</label>

                        <!--   <input type="radio" name="desayuno" value="1">SI
                        <input type="radio" name="desayuno" value="0">No -->
                        <select name="desayuno" id="desayuno" required>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </li>
                    <li>
                        <label for="grupo">Grupo:</label>
                        <select name="grupo" id="grupo">
                            <?php
                            $sql = $con->prepare("SELECT*FROM grupo");
                            $sql->execute();
                            $ejecutar = $sql->fetchAll();
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
                        <input type="text" name="calle" id="calle" placeholder="Calle">
                    </li>
                    <li>
                        <label for="numero">Número:</label>
                        <input type="text" name="numero" id="numero" placeholder="número">
                    </li>
                    <li>

                        <label for="codigo">Código Postal:</label>
                        <input type="text" name="codigo" id="codigo" placeholder="00000" required oninput="consultaCP(this.value)">

                    <li></li>
                    <li></li>
                    <li></li>


                    <li>
                        <label for="estado">Estado:</label>

                        <select name="estado" id="estado">
                            <?php
                            $sql = $con->prepare("SELECT*FROM estados where idEstado=28");
                            $sql->execute();
                            $ejecutar = $sql->fetchAll();
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
                            $sql = $con->prepare("SELECT*FROM municipio where idEstado=28");
                            $sql->execute();
                            $ejecutar = $sql->fetchAll();
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
                    <ul>
                        <li><input type="submit" value="Crear Alumno" class="btn_Guardar"></li>
                        <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                    </ul>
                </ul>

            </form>
        </div>


    </section>
    <!-- Script para indicar las colonias de un codigo postal-->
    <script type="text/javascript">
        function check(o) {
            v = o.value.replace(/^\s+|\s+$/, ''); // quitar cualquier espacio en blanco

            if (o == '') {
                return;
            }
            v = v.substr(v.length - 1);
            if (v.match(/\d/g) == null) {
                o.value = o.value.substr(0, o.value.length - 1).replace(/^\s+|\s+$/, '');
            }
        }

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