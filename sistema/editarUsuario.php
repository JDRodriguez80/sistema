<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$id = $_GET['id'];
if (!empty($_POST)) {
    $alert = "";
    if (
        empty($_POST['usuario'] || $_POST['email'] || $_POST['nivel'])
    ) {
        $alert = '<p class="msg_error"> Favor de llenar todos los campos requeridos </p>';
    } else {

        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $nivel = $_POST['nivel'];
        // checando por duplicado
        $querry = $con->prepare("SELECT * FROM usuarios where usuario=:usuario and email=:email");
        $querry->bindParam(":usuario", $usuario);
        $querry->bindParam(":email", $email);
        $querry->execute();


            $querry = $con->prepare("UPDATE usuarios SET email=:email, nivelUsuario=:nivel WHERE idUsuario=:id");
            $querry->bindParam(":email", $email);
            $querry->bindParam(":nivel", $nivel);
            $querry->bindParam(":id", $id);
            $querry->execute();
            if ($querry) {
                $alert = '<p class="msg_success"> usuario modificado de manera correcta. </p>';
                header("LOCATION:ListarUsuarios.php");
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
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Editar Usuario</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Editar de Usuario</h1>

            <div class="alert"><?php echo isset($alert) ? $alert : '' ?> </div>
            <form action="" method="post">
                <?php
                $sql = $con->prepare("SELECT * FROM usuarios WHERE idUsuario=:id");
                $sql->bindParam(":id", $id);
                $sql->execute();

                foreach ($sql as $valores) {
                    $usuarioForm = $valores['usuario'];
                    $emailForm = $valores['email'];
                }
                ?>
                <label for="usuario">Usuario:</label>
                <input type="hidden" readonly name="usuario" id="usuario" value="<?php echo $usuarioForm ?>">
                <h3><?php echo $usuarioForm ?></h3>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?php echo $emailForm ?>">
                <label for=nivel>Nivel:</label>
                <select name="nivel" id="nivel" required>
                    <option value="1">Administrador</option>
                    <option value="2">Directivo</option>
                    <option value="3">Control Escolar</option>
                    <option value="4">Psicólogo</option>
                    <option value="5">Docente</option>
                    <option value="6">Médico</option>
                    <option value="7">Terapista</option>
                    <option value="8">Comunicación</option>
                    <option value="9">Padre</option>
                </select>
                <input type="submit" value="Editar Usuario" class="btn_secondary-color-dark">
                <input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger">

            </form>

        </div>
    </section>
    <?php include "includes/footer.php"; ?>

</body>

</html>