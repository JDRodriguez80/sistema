<?php
require '../conexion.php';
session_start();
$conn = new Database();
$con = $conn->conectar();

//checando por post vacio
if (!empty($_POST)) {
    //checando por campos vacios
    if (
        empty($_POST['nombre']) || empty($_POST['primApellido'] || empty($_POST['fdn'])) || empty($_POST['fdi']) || empty($_POST['fdict'])
        || empty($_POST['noPlaza'] || empty($_POST['funcion'])) || empty($_POST['nombre']) || empty($_POST['sostenimiento']) || empty($_POST['curp']) || empty($_POST['rfc'])
        || empty($_POST['usuario'] || empty($_POST['email']))
    ) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        //sanitiando campos
        //sanirizando email
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        //checando si el email es valido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert = '<p class="msg_error">El email no es valido</p>';
        }
        //validando curp
        //checando por longitud del curp
        if ($_POST['curp'] == "" || strlen($_POST['curp']) != 18) {
            $alert = '<p class="msg_error"> El curp debe de tener 18 caracteres</p>';
        }
        //checando por formato del curp
        if (!preg_match("/^[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]{2}$/", $_POST['curp'])) {
            $alert = '<p class="msg_error"> El curp no tiene el formato correcto</p>';
        } else {
            $nombre = $_POST['nombre'];
            $primApellido = $_POST['primApellido'];
            $segApellido = $_POST['segApellido'];
            $fdn = $_POST['fdn'];
            $fdi = $_POST['fdi'];
            $fdict = $_POST['fdict'];
            $noPlaza = $_POST['noPlaza'];
            $funcion = $_POST['funcion'];
            $sostenimiento = $_POST['sostenimiento'];
            $curp = $_POST['curp'];
            $rfc = $_POST['rfc'];
            $usuario = $_POST['usuario'];
            $emailSan = $email;
            $nivel = $_POST['nivel'];
            $password = md5("cam10s"); //password por default que debera ser cambiado al momento del primer acceso
            $hash = md5(rand(0, 1000)); //creando hash personalizado para cada usuario, este sera utilizado para fines de verificacion de email y activacion de cuenta.
            $estatus = 0; //estatus por default de la cuenta, 0 = inactiva, 1 = activa
            //checando si el usuario ya existe
            $querry = $con->prepare("SELECT * FROM usuarios WHERE usuario = '$usuario' OR email = '$email'");
            $querry->execute();
            $result = $querry->fetch(PDO::FETCH_ASSOC);
            if ($result > 0) {
                $alert = '<p class="msg_error">El correo o el usuario ya existe</p>';
            }
            //checando si el curp ya existe
            $querry = $con->prepare("SELECT * FROM personal WHERE curp = '$curp'");
            $querry->execute();
            $result = $querry->fetch(PDO::FETCH_ASSOC);
            if ($result > 0) {
                $alert = '<p class="msg_error">El curp ya existe</p>';
            }
            //insertando usuario en base de datos
            $querry6 = $con->prepare("INSERT INTO usuarios(usuario, email, password, estatus, nivelUsuario, hash)VALUES(:usuario, :email, :password, :estatus, :idNivel, :hash)");
            
            $querry6->bindParam(':usuario', $usuario);
            $querry6->bindParam(':email', $emailSan);
            $querry6->bindParam(':password', $password);
            $querry6->bindParam(':estatus', $estatus);
            $querry6->bindParam(':idNivel', $nivel);
            $querry6->bindParam(':hash', $hash);
            $querry6->execute();
            $result = $querry6->fetch(PDO::FETCH_ASSOC);
            //obteniendo id del usuario
            $querry7 = $con->prepare("SELECT idUsuario FROM usuarios WHERE usuario = '$usuario'");
            $querry7->execute();
            $result = $querry7->fetch(PDO::FETCH_ASSOC);
            $idUsuario = $result['idUsuario'];
            //insertando personal en base de datos
            $querry = $con->prepare("INSERT INTO personal(nombres, primApellido, segApellido, fdn, ingresoSep, ingresoCtt, noPlaza, idfuncion, idSostenimiento, curp, rfc, idUsuario,idNivel)VALUES(:nombre, :primerApellido, :segundoApellido, :fechaNacimiento, :fechaIngreso, :fechaIngresoCT, :noPlaza, :funcion, :sostenimiento, :curp, :rfc, :idUsuario, :idNivel)");
            $querry->bindParam(':nombre', $nombre);
            $querry->bindParam(':primerApellido', $primApellido);
            $querry->bindParam(':segundoApellido', $segApellido);
            $querry->bindParam(':fechaNacimiento', $fdn);
            $querry->bindParam(':fechaIngreso', $fdi);
            $querry->bindParam(':fechaIngresoCT', $fdict);
            $querry->bindParam(':noPlaza', $noPlaza);
            $querry->bindParam(':funcion', $funcion);
            $querry->bindParam(':sostenimiento', $sostenimiento);
            $querry->bindParam(':curp', $curp);
            $querry->bindParam(':rfc', $rfc);
            $querry->bindParam(':idUsuario', $idUsuario);
            $querry->bindParam(':idNivel', $nivel);
            $querry->execute();
            $result = $querry->fetch(PDO::FETCH_ASSOC);
            if ($result > 0) {
                $alert = '<p class="msg_error">Error al registrar el personal</p>';
            } else {
                $alert = '<p class="msg_save">Personal registrado correctamente</p>';
            }
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
    <title>Personal</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Registro de Personal</h1>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post">
                <h3>Datos personales</h3>
                <ul>
                    <li>
                        <label for="nombre">Nombres</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre">
                    </li>
                    <li>
                        <label for="primApellido">Primer apellido</label>
                        <input type="text" name="primApellido" id="primApellido" placeholder="Primer apellido">
                    </li>
                    <li>
                        <label for="segApellido">Segundo apellido</label>
                        <input type="text" name="segApellido" id="segApellido" placeholder="Segundo apellido">
                    </li>
                </ul>
                <ul>
                    <li>
                        <label for="fdn">Fecha de nacimiento</label>
                        <input type="date" name="fdn" id="fdn" placeholder="Fecha de nacimiento">
                    </li>
                    <li>
                        <label for="fdi">Fecha de ingreso a SEP</label>
                        <input type="date" name="fdi" id="fdi" placeholder="Fecha de ingreso a SEP">
                    </li>
                    <li>
                        <label for="fdict">Fecha de ingreso a C.T </label>
                        <input type="date" name="fdict" id="fdict" placeholder="Fecha de ingreso a C.T">
                    </li>
                    <li>
                        <label for="noPlaza">Numero de plaza</label>
                        <input type="text" name="noPlaza" id="noPlaza" placeholder="Numero de plaza">
                    </li>
                    <li>
                        <label for="funcion">Función:</label>
                        <select name="funcion" id="funcion">
                            <?php
                            $querry = $con->prepare("SELECT * FROM funcion");
                            $querry->execute();
                            $result = $querry->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                echo "<option value='" . $row['idFuncion'] . "'>" . $row['funcion'] . "</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="sostenimiento">Sostenimiento</label>
                        <select name="sostenimiento" id="sostenimiento">
                            <?php
                            $querry = $con->prepare("SELECT * FROM sostenimiento");
                            $querry->execute();
                            $result2 = $querry->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result2 as $row) {
                                echo "<option value='" . $row['idSostenimiento'] . "'>" . $row['Sostenimiento'] . "</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="curp">CURP:</label>
                        <input type="text" name="curp" id="curp" placeholder="CURP">
                    </li>
                    <li><label for="rfc">RFC</label>
                        <input type="text" name="rfc" id="rfc" placeholder="RFC">
                    </li>
                    <br>
                    <br>

                    <h3>Datos de usuario</h3>
                    <ul>
                        <li>
                            <label for="usuario">Usuario</label>
                            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                        </li>
                        <li>
                            <label for="email">Correo</label>
                            <input type="email" name="email" id="email" placeholder="Correo">
                        </li>
                        <li>
                            <label for="nivel">Nivel de acceso</label>
                            <select name="nivel" id="nivel">
                                <?php
                                $querry = $con->prepare("SELECT * FROM nivelUsuarios");
                                $querry->execute();
                                $result3 = $querry->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result3 as $row) {
                                    echo "<option value='" . $row['idNivel'] . "'>" . $row['nombreNivel'] . "</option>";
                                }
                                ?>
                            </select>
                        </li>
                    </ul>
                </ul>

                <ul>
                    <li><input type="submit" value="Crear Personal" class="btn_Guardar"></li>
                    <li><input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger"></li>
                </ul>
            </form>
        </div>

    </section>
</body>

</html>