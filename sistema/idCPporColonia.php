<?php
session_start();
include_once "conexion.php";
$colonia=$_GET['colonia'];
$consulta="SELECT idCP FROM codigopostal where Colonia='$colonia'";
$ejecutar=mysqli_query($conn, $consulta) or die(mysqli_error($conn));

?>
<?php foreach ($ejecutar as $opciones):?>
<input type="text" id="codigoPostalID" name="codigoPostalID" value="<?php echo $opciones['idCP']?>">
<?php endforeach; ?>
