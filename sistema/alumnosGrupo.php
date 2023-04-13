<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$grupo = $_GET['idGrupo'];

$query = $con->prepare("call spListarAlumno('$grupo')");
$query->setFetchMode(PDO::FETCH_ASSOC);
$query->execute();
$ejecutar = $query->fetchAll();

?>
<a class="btn_Icon" href="reporteAlumnos.php?id=<?php echo $grupo; ?>"><i class="fa-solid fa-address-book"></i> Reporte </a>
<br>

<br>
<tr>
    <th>ID</th>
    <th>CURP</th>
    <th>Nombres</th>
    <th>Primer Apellido</th>
    <th>Segundo Apellido</th>
    <th>Acciones</th>

</tr>
<?php foreach ($ejecutar as $data) : ?>



    <tr>
        <td><?php echo $data['idAlumno'] ?></td>
        <td><?php echo $data['curp'] ?></td>
        <td><?php echo $data['nombre'] ?></td>
        <td><?php echo $data['primApellido'] ?></td>
        <td><?php echo $data['segApellido'] ?></td>
        <td>
            <a class="edit" href="alumnoEditar.php?id=<?php echo  $data['idAlumno'] ?>"><i class="fa-solid fa-user-pen fa-2x"> </i> EDITAR</a>
            |
            <a class="delete" href="eliminarAlumno.php?id=<?php echo $data['idAlumno'] ?>"><i class="fa-solid fa-2x fa-user-xmark"></i> BORRAR</a>

        </td>
    </tr>
<?php endforeach; ?>