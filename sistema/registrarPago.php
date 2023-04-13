<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
//datos de la tabla
/* 
    idPago/ai
    idTipoPago
    fechaPago
    idPersonal
    idAlumno
    abono
    resto
    montoPago//total
*/
//checar por session activa
if (empty($_SESSION['active'])) {
    header('location: ../index.php');
}
$nivel = $_SESSION['nivelUsuario'];

//checando por privilegios de usuario
if ($nivel != 1 || $nivel != 2) {
    header('location index.php');
}
//haciendo consulta para obtener los datos del alumno
$query = $con->prepare("SELECT * FROM alumnos order by curp asc");

?>
<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/scripts.php' ?>
    <title>Pagos | Lista</title>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section id="container">
        <div class="form-Registro2">
            <h1>Listado de Alumnos</h1>
            <table id="tbAlumnos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CURP</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query->execute();
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $data) {
                    ?>
                        <tr>
                            <td><?php echo $data['idAlumno'] ?></td>
                            <td><?php echo $data['curp'] ?></td>
                            <td><?php echo $data['nombre'] ?></td>
                            <td><?php echo $data['primApellido'] ?></td>
                            <td><?php echo $data['segApellido'] ?></td>
                            <td>
                                <a href="agregarPago.php?id=<?php echo $data['idAlumno'] ?>&grupo=<?php echo $data['idGrupo'] ?>" class="edit"><i class="fa-regular fa-id-card fa-2x"></i> Registrar Pago</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- script para generar tabla -->
    <script type="text/javascript">
        //jSModalEditar("",300);
        function listar(idGrupo) {
            var conexion;
            if (idGrupo == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                conexion = new XMLHttpRequest();
            }
            conexion.onreadystatechange = function() {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    document.getElementById("tbAlumnos").innerHTML = conexion.responseText;
                }
            }
            conexion.open("GET", "alumnosPago.php?idGrupo=" + idGrupo, true);
            conexion.send();
        }
    </script>
    <script>
        var tabla = new DataTable("#tbAlumnos", {
            searchable: true,
            perPage: 5,
            fixedColumns: true,
            sortable: false,
            perPageSelect: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });
    </script>
    <?php include 'includes/footer.php' ?>
</body>

</html>