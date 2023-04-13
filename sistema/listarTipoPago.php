<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$alert = '';
if (!$_SESSION['active'] == true) {
    header('location: ../index.php');
} else {
    //checando por privilegios de usuario
    $nivel = $_SESSION['nivelUsuario'];
    if ($nivel != 1 || $nivel != 2) {
        header('location index.php');
    }
    //trayendo datos
    $query = $con->prepare("SELECT * FROM tipoPago");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

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
            <br>
            <h1>Lista de Tipos de Pago</h1>
            <table id="tbTipoPago">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $data) : ?>
                        <tr>
                            <td><?php echo $data['idTipoPago'] ?></td>
                            <td><?php echo $data['nombrePago'] ?></td>
                            <td><?php echo $data['descripcion'] ?></td>
                            <td>
                                <a class="add" href="editarTipoPago.php?id=<?php echo $data['idTipoPago'] ?>"><i class="fa-solid fa-money-check-dollar fa-2x"></i> Editar</a>
                                |
                                <a class="delete" href="eliminarTipoPago.php?id=<?php echo $data['idTipoPago'] ?>"><i class="fa-solid fa-money-check-dollar fa-2x"></i> Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php include 'includes/footer.php' ?>
    <script>
        var tabla = new DataTable("#tbTipoPago", {
            searchable: true,
            perPage: 5,
            fixedColumns: true,
            sortable: false,
            perPageSelect: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            labels: {
                placeholder: "Buscar Registro...",
                perPage: "{select} Registros por página",
                noRows: "No hay actas",
                info: "Mostrando {start} a {end} de {rows} registros ({pages} páginas)"
            }
        });
    </script>
</body>

</html>