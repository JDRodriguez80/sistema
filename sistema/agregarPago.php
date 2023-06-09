<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
$idAlumno = $_GET['id'];
$idGrupo = $_GET['grupo'];
//checando por session activa
if (empty($_SESSION['active'])) {
    header('location: ../index.php');
}
//checando por privilegios de usuario
if ($_SESSION['nivelUsuario'] != 1 && $_SESSION['nivelUsuario'] != 2) {
    // header('location: index.php');
    echo "No tienes permiso para acceder a esta pagina";
}
//checando si se recibio el id del alumno
if (empty($idAlumno)) {
    // header('location: index.php');
    echo "No se recibio el id del alumno";
}
//checando si se recibio el id del grupo
if (empty($idGrupo)) {
    //header('location: index.php');
    echo "No se recibio el id del grupo";
}
//checando por el post
if (!empty($_POST)) {
    //checando por vacios
    if (empty($_POST['idTipoPago']) || empty($_POST['fecha']) || empty($_POST['abono'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        //sanitizar datos
        $idTipoPago = $_POST['idTipoPago'];
        $fecha = $_POST['fecha'];
        $abono = $_POST['abono'];


        $idPersonal = $_SESSION['idUsuario'];
        //asegurando que los datos sean numericos
        if (is_numeric($abono)) {
            //checando por el resto

            //seleccionando total a pagar
            $querry = $con->prepare("SELECT * FROM tipoPago WHERE idTipoPago = :idTipoPago");
            $querry->bindParam(":idTipoPago", $_POST['idTipoPago']);
            $querry->execute();
            $result = $querry->fetchAll(PDO::FETCH_ASSOC);
            $totalAPagar = $result[0]['total'];


            //insertando datos
            $idTipoPago = $_POST['idTipoPago'];
            $fecha = $_POST['fecha'];
            $idPersonal = $_SESSION['idUsuario'];
            $idAlumno = $_GET['id'];
            $abono = $_POST['abono'];
            
            
                $querry = $con->prepare("INSERT INTO pagos(idTipoPago, fechaPago,idPersonal, idAlumno, abono, totalPago)
                    VALUES(:idTipoPago, :fechaPago, :idPersonal, :idAlumno, :abono, :totalPago)
                    ");
                $querry->bindParam(":idTipoPago", $idTipoPago);
                $querry->bindParam(":fechaPago", $fecha);
                $querry->bindParam(":idPersonal", $idPersonal);
                $querry->bindParam(":idAlumno", $idAlumno);
                $querry->bindParam(":abono", $abono);
                $querry->bindParam(":totalPago", $totalAPagar);
                $querry->execute();

                if ($querry) {
                    $alert = '<p class="msg_save">Pago registrado correctamente</p>';
                } else {
                    $alert = '<p class="msg_error">Error al registrar el pago</p>';
                }
            
        } else {
            $alert = '<p class="msg_error">Los datos deben ser numericos</p>';
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
    <title>Abonar Pago</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <div class="form-Registro2">
            <h1>Resgistrar Pago</h1>
            <form action="" method="POST">
                <div class="alert"><?php echo isset($alert) ? $alert : '' ?></div>


                <label for="idTipoPago">Tipo de Pago</label>
                <select name="idTipoPago" id="idTipoPago">
                    <?php $querry = $con->prepare("SELECT * FROM tipoPago");
                    $querry->execute();
                    $result = $querry->fetchAll(PDO::FETCH_ASSOC); ?>
                    <?php foreach ($result as $tipoPago) { ?>

                        <option value="<?php echo $tipoPago['idTipoPago'] ?>"><?php echo $tipoPago['nombrePago'] ?></option>
                    <?php } ?>
                </select>

                <ul>
                    <li>
                        <label for="fecha">Fecha de Pago:</label>
                        <input type="date" name="fecha" id="fecha">
                    </li>
                    <li>
                        <label for="abono">Abono $:</label>
                        <input type="number" name="abono" id="abono" placeholder="0.00">
                    </li>


                </ul>
                <ul style=" align-items: flex-end;">
                    <li><input type="submit" value="Registrar" class="btn_Guardar"></li>
                    <li><input type="button" onclick="window.location.href='registrarPago.php';" value="Salir" class="btn_Danger"></li>
                </ul>

            </form>
        </div>
    </section>
    <?php include 'includes/footer.php' ?>
</body>

</html>