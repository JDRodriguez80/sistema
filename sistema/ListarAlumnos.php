<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$id = '';

?>

<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alumnos | Lista</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de Alumnos</h1>
        <form method="post" class="form_search">
            <label for="Grupo" style="padding-right: 1em">Grupo:</label>
            <br>
            <select name="grupo" id="Grupo" onclick="listar(this.value)">
                <?php
                $query = $con->query("SELECT*FROM grupo");
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();
                $ejecutar = $query->fetchAll();

                ?>
                <?php
                foreach ($ejecutar as $opciones) : ?>
                    <option value="<?php echo $opciones['idGrupo']; ?>"><?php echo $opciones['grupo'] ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <br>
        <br>
        <br>
        <br>
        <table id="tbAlumnos">
            <br>
            <br>
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
        </table>
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
            conexion.open("GET", "alumnosGrupo.php?idGrupo=" + idGrupo, true);
            conexion.send();
        }
    </script>
   
    <?php include "includes/footer.php"; ?>
</body>

</html>