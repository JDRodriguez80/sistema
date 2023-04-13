<?php
session_start();
require_once "../conexion.php";

$consulta="SELECT * FROM grupo";
$execute=mysqli_query($conn, $consulta);

while($fila=mysqli_fetch_array($execute)){
        echo "<option value='".$fila['id']."'>".$fila['grupo']."</option>";
}