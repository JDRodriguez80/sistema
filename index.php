<?php
session_start();
require "conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
if(!empty($_SESSION['activa'])){
    header('location:sistema/');
}else if(!empty($_POST)){
    if(empty($_POST['email'])){ //checando por correo vacio
        $alert='Email vacio';
        $email=$_POST['email'];
        if(filter_var($email, FILTER_VALIDATE_EMAIL)===false){ //checando por email invalido (formato)
            $alert='Email invalido';
        }
    }elseif (empty($_POST['password'])){
        $alert='Contraseña vacia';  //checando por contraseña vacia
    }else{
       
        //igualando a variables el contenido en el metodo post
        //limpiando caracteres especiales y  espacios de los campos de usuario y contraseña
        $email=$_POST['email'];
        //encriptando en md5 la contraseña

        $pass=md5($_POST['password']);

        //llamando al procedimiento almacenado de login pasandole los parametros email y contraseña
        $query=$con->prepare("CALL spLogin(?,?)");
        $query->bindParam(1,$email);$query->bindParam(2,$pass);
        $query->execute();
        $datos=$query->fetchAll();
        //igualando el resultado de la consulta a la variable $result
       //checando si la consulta trae resultados
       if($datos){
           //igualando a data los resultados del array
            $data=$datos[0];
            $_SESSION['active']=true; //activando la sesión
            //igualando lo contendio en el array al array de la sesión
            $_SESSION['idUsuario']=$data['idUsuario'];
            $_SESSION['usuario']=$data['usuario'];
            $_SESSION['email']=$data['email'];
            $_SESSION['estatus']=$data['estatus'];
            $_SESSION['nivelUsuario']=$data['nivelUsuario'];
            $_SESSION['hash']=$data['hash'];
            //checando por usuario activo
            if($_SESSION['estatus']==0){
                header('location:sistema/mailerEx.php');
            }else{header('location:sistema/');} //loging exitoso, enviando al menu principal

       }else{
            $alert='Usuario o clave incorrecta'; //fallo de autentificación
            session_destroy();

       }
    }
}


?>
<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIIECAM | LOGIN</title>
    <link rel="stylesheet" href="css/loginStyle.css">
    <!-- Script para captcha de google-->
    <script src="https://www.google.com/recaptcha/api.js"></script>


</head>

<body>
    <section id="container">
        <form id="log-in" action="" method="post">

            <img src="img/image.png" alt="LogIn">
            <h3>Login</h3>

            <input type="text" name="email" placeholder="Correo electrónico">
            <input type="password" name="password" placeholder="Password">
            <h4> ¿Olvidaste tu contraseña?</h4>
            <h4> <a href="#">Haz click para recuperarla</a></h4>
            <div class="alerta"><?php echo $alert ?? '';  ?></div>
            <input class="g-recaptcha" data-sitekey="6LdqcCgiAAAAAPnRD_p4hDpt-1G2Y456qOXsN70n" data-callback='onSubmit' data-action='submit' type="submit" value="INGRESAR" />
            <h4 class="leyenda">Logo propiedad del CAM "Prof. Nicasio Zúñiga Huerta"</h4>
        </form>
    </section>
    <!-- Script para captcha de google-->
    <script>
        function onSubmit(token) {
            document.getElementById("log-in").submit();
        }
    </script>
</body>

</html>