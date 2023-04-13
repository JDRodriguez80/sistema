<?php
session_start();
    if(empty($_POST)){
        $alert='';
    $usuario=$_POST['user'];
    $email=$_POST['email'];
    $hash=$_POST['hash'];
    //datos para el correo de confirmación
    $to = $email;//destino
        $usuario='Jesus';
        $email='Jesus1280rodriguez@gmail.com';
        $hash='hash';
    $subject='Verificación de cuenta';//asunto del correo
    $message='
        <p>Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"
        Una cuenta para padre de familia ha sido creada para usted por parte de control escolar con los siguientes datos:
        =================================================================================================================
       <b> Correo: '.$email.'</b>
        
       <b>Usuario: '.$usuario.';</b> 
        =================================================================================================================
        </p>
        <p>
        Para activar esta cuenta haga clic en el siguiente enlace
        https://siiiecam.com/prompActivar.php?email='.$email.'&hash='.$hash.'
        Este es un correo auto generado por lo que no admite respuestas,
        si tiene algúna duda favor de dirigirse de manera personal a la escuela
        o bien enviar sus dudas al correo de contacto que se adjunta mas abajo.
        Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"
        Esteritos S/N, Fracc. Tecnológico, Heroica Matamoros Tamaulipas 87490
        SIIIECAM 2022. Todos los derechos reservados.
        Contacto: contacto@siiiecam.com 
        =================================================================================================================
        </p>
        
        <b>Aviso de Privacidad</b>
        <p>
        El contenido de este mensaje por medio electrónico incluyendo datos, texto, imágenes y/o enlaces a 
        otros contenidos tiene el carácter de confidencial y de uso exclusivo del "Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"
        así como de las personas y/o empresas a las que se dirige.
        
        No se considera oferta, propuesta o acuerdo sino hasta que sea confirmado en documento por escrito que contenga la firma autógrafa
        del servidor público autorizado legalmente para esta operación.
          
        El contenido es de carácter confidencial por lo cual no podrá distribuirse y/o difundirse por ningún medio
        sin la previa autorización del emisor original.Si usted no es el destinatario se le prohíbe su utilización total
        o parcial para cualquier fin. 
        El árbol que servirá para hacer el papel, tardará 7 años en crecer. No imprimas este mensaje si no es necesario. </p>  
    ';
    $headers='From:noreplay@siiiecam.com'."\r\n";
        mail($to, $subject, $message, $headers);//Enviando correo
        $alert='<p class="msg_successr"> Correo de verificación enviado. </p>';
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

    <title>Activación</title>
</head>
<body>
<?php include 'includes/header2.php'?>
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
