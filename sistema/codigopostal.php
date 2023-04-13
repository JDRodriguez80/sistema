<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con =$conn->conectar();

$codigo=$_GET['cp'];
$idCodigo;
$sql=$con->prepare("SELECT *FROM codigopostal WHERE CP=:codigo");
$sql->bindParam(':codigo',$codigo);
$sql->execute();
$ejecutar=$sql->fetchAll();

?>
<?php foreach ($ejecutar as $opciones):?>
    <option value="<?php echo $opciones['idCP']?>"><?php echo $opciones['Colonia']?></option>


<?php endforeach;?>


