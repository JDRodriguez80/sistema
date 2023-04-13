<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

if(!empty($_POST)){
    $alert="";
if(!empty($_POST)){
$alert='';
if(empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['password'])) {
    $alert = '<p class="msg_error"> Favor de llenar todos los campos. </p>';
    }else{
        $usuario=$_POST['usuario'];
        $email=$_POST['email'];
        $prePassword=$_POST['password'];
        $password=md5($prePassword);//encriptando el password
        $hash=md5( rand(0,1000) );//generando un hash que servira para la autentificación del correo
        $estatus=0;// valor por default desactivado
        $nivel=$_POST['nivel'];
        //verificando duplicados
        $query=$con->prepare("SELECT * FROM usuarios where usuario=:usuario or email=:email");
        $query->bindParam(":usuario", $usuario);
        $query->bindParam(":email", $email);
        $query->execute();
        
        if($query->rowCount() > 0){
            $alert='<p class="msg_error"> Correo electronico o usuario ya existen </p>';
        }else{
            //insertando datos
            $queryInsert=$con->prepare("INSERT INTO usuarios (usuario, email, password, estatus, nivelUsuario, hash) VALUES (:usuario,:email, :password,:estatus,:nivel,:hash)");
            $queryInsert->bindParam(":usuario", $usuario);
            $queryInsert->bindParam(":email", $email);
            $queryInsert->bindParam(":password", $password);
            $queryInsert->bindParam(":estatus", $estatus);
            $queryInsert->bindParam(":nivel", $nivel);
            $queryInsert->bindParam(":hash", $hash);
            $queryInsert->execute();
            
            if ($queryInsert){
                $alert='<p class="msg_success"> Usuario agregado de manera correcta. </p>';
                header("LOCATION:ListarUsuarios.php");
            }else{
                $alert='<p class="msg_error"> Fallo en la inserción, favor de checar la información. </p>>';
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
    <?php include "../sistema/includes/scripts.php";?>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Registrar Usuario</title>
</head>
<body>
<?php include 'includes/header.php'?>
<section id="container">
    <div class="form-Registro2">
        <h1>Registro de Usuario</h1>

        <div class="alert"><?php echo isset($alert) ? $alert:'' ?> </div>
        <form action="" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" placeholder="usuario")">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email"placeholder="email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password">
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
            <input type="submit" value="Crear Usuario" class="btn_Guardar">
            <input type="button" onclick="window.location.href='index.php';" value="Salir" class="btn_Danger">

        </form>

    </div>
</section>
<?php include "includes/footer.php";?>

</body>
</html>


