<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';
if(empty($_POST)){
$alert='';
$usuario=$_POST['usuario'];
$email=$_POST['email'];
$hash=$_POST['hash'];
$mail = new PHPMailer(true);


try {
    //Server settings
                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'SMTP.titan.email';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'no-replay@siiiecam.com';                     //SMTP username
    $mail->Password   = 'bljp201280';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->isHTML(true);

    //Recipients
    $mail->setFrom('no-replay@siiiecam.com', 'SIIIECAM');
    $mail->addAddress('jesus1280rodriguez@gmail.com', 'Jesus');     //Add a recipient



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'ACTIVACION';
    $mail->Body    = ' <h1> Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"</h1>
       <br>  
       <p>
       Una cuenta para padre de familia ha sido creada para usted por parte de control escolar con los siguientes datos: <br>
       <hr>
       <br>
        <b>Correo:</b> '.$email.' <br>
         
        <b>Usuario: </b>'.$usuario.';
        <br>
        
        Para activar esta cuenta haga clic en el siguiente enlace:
        <hr>
        https://siiiecam.com/prompActivar.php?email='.$email.'&hash='.$hash.'
        <hr>
        <h4>
        Este es un correo auto generado por lo que no admite respuestas,
        si tiene algúna duda favor de dirigirse de manera personal a la escuela
        o bien enviar sus dudas al correo de contacto que se adjunta mas abajo.
        Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"
        Esteritos S/N, Fracc. Tecnológico, Heroica Matamoros Tamaulipas 87490
        SIIIECAM 2022. Todos los derechos reservados.
        Contacto: contacto@siiiecam.com 
        </h4>
        =================================================================================================================
        </p>
       <p> 
        <b>Aviso de Privacidad</b>
        <h5>
        El contenido de este mensaje por medio electrónico incluyendo datos, texto, imágenes y/o enlaces a 
        otros contenidos tiene el carácter de confidencial y de uso exclusivo del "Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"
        así como de las personas y/o empresas a las que se dirige.
        
        No se considera oferta, propuesta o acuerdo sino hasta que sea confirmado en documento por escrito que contenga la firma autógrafa
        del servidor público autorizado legalmente para esta operación.
          
        El contenido es de carácter confidencial por lo cual no podrá distribuirse y/o difundirse por ningún medio
        sin la previa autorización del emisor original.Si usted no es el destinatario se le prohíbe su utilización total
        o parcial para cualquier fin. 
        El árbol que servirá para hacer el papel, tardará 7 años en crecer. No imprimas este mensaje si no es necesario.
        </p>
        </h5>
    ';

   // $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {

    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
};
?>

<!doctype html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8">
    <?php include "../sistema/includes/scripts.php";?>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Activación</title>
</head>
<body>

<section id="container">
    <form action="" method="post">
        <H1>Su cuenta necesita ser activada.</H1>
        <p>Para activar de click en el siguiente boton, y se enviara un mensaje a su correo, con las instrucciónes a seguir</p>
    </form>
    <input type="Submit" value="Activar Correo" class="btn_Guardar">
</section>
<?php include "includes/footer.php";?>
</body>
</html>
