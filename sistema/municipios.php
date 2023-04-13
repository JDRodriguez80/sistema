<?php
session_start();
include_once "conexion.php";
$estado=$_GET['idEstado'];
$consulta="SELECT * FROM 'municipio' WHERE idEstado='$estado'";
$ejecutar=mysqli_query($conn, $consulta) or die(mysqli_error($conn));
?>

<?php foreach ($ejecutar as $opciones):?>
    <option value="<?php echo $opciones['idMunicipio']?>"><?php echo $opciones['municipio']?></option>
<?php endforeach;?>