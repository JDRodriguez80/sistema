<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['primApellido']) || empty($_POST['telefono']) || empty($_POST['oficio']) || empty($_POST['curp']) || empty($_POST['escolaridad'])) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos. </p>';
    } else {
        
        $nombre = $_POST['nombre'];
        $primApellido = $_POST['primApellido'];
        $segApellido = $_POST['segApellido'];
        $telefono = $_POST['telefono'];
        $oficio = $_POST['oficio'];
        $curp = $_POST['curp'];
        $escolaridad = $_POST['escolaridad'];
        $user = $_POST['usuario'];
        $email = $_POST['email'];
        //valores por defecto
        $idNivel = 9; //relativo a nivel "padre de familia"
        $estatus = 0; //desactivado
        $password = md5("cam10s"); //password por default que debera ser cambiado al momento del primer acceso del padre de familia
        $hash = md5(rand(0, 1000)); //creando hash personalizado para cada usuario, este sera utilizado para fines de verificacion de email y activacion de cuenta.

        // checando por dupicidades en la base de datos
        $stmt = $con->prepare("SELECT * FROM usuarios WHERE usuario = :user OR email = :email");
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result > 0) {
            $alert = '<p class="msg_error"> Correo electronico o usuario ya existen </p>';
        } else {
            $stmt = $con->prepare("CALL spCrearPadre(:user, :email, :password, :estatus, :idNivel, :hash, :nombre, :primApellido, :segApellido, :telefono, :oficio, :curp, :escolaridad)");
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':estatus', $estatus);
            $stmt->bindParam(':idNivel', $idNivel);
            $stmt->bindParam(':hash', $hash);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':primApellido', $primApellido);
            $stmt->bindParam(':segApellido', $segApellido);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':oficio', $oficio);
            $stmt->bindParam(':curp', $curp);
            $stmt->bindParam(':escolaridad', $escolaridad);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $alert = '<p class="msg_success"> Padre agregado de manera correcta. </p>';
                header("refresh:2; url=index.php");
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
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Registrar Padre</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro">
            <h1>Registro de padres</h1>

            <div class="alert"><?php echo isset($alert) ? $alert : '' ?> </div>
            <form action="" method="post">



                <label for="nombres">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Padre">
                <label for="primApellido">Primer Apellido:</label>
                <input type="text" name="primApellido" id="primApellido" placeholder="Primer Apellido">
                <label for="segApellido">Segundo Apellido:</label>
                <input type="text" name="segApellido" id="segApellido" placeholder="Segundo Apellido">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono">
                <label for="oficio">Oficio:</label>
                <input type="text" name="oficio" id="oficio" placeholder="Oficio">
                <label for="curp">CURP:</label>
                <input type="text" name="curp" id="curp" placeholder="CURP">
                <label for="email">Correo Electrónico:</label>
                <input type="text" name="email" id="email" placeholder="Email Padre">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                <label for="Escolaridad">Escolaridad:</label>
                <select name="escolaridad" id="escolaridad">

                    <?php
                    
                    $consulta = "SELECT * FROM escolaridad";
                    $querry=$con->prepare($consulta);
                    $querry->execute();
                    $ejecutar=$querry->fetchAll();
                    

                    ?>
                    <?php foreach ($ejecutar as $opciones) : ?>
                        <option value="<?php echo $opciones['idEscolaridad'] ?>"><?php echo $opciones['escolaridad'] ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Crear Padre" class="btn_Guardar"></li>
                <input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger">

            </form>

        </div>
    </section>
    <?php include "includes/footer.php"; ?>

</body>

</html>