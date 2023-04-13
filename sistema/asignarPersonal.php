<?php
session_start();
require "../conexion.php";
$conn = new Database();
$con = $conn->conectar();
$querry = $con->prepare("SELECT * From grupo inner join seccion s on grupo.idSeccion = s.idSeccion");
$querry->execute();
$ejecutar = $querry->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="es-mx">

<head>
    <meta charset="UTF-8">
    <?php include "../sistema/includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Grupo | Lista</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <h1>Lista de Grupos</h1>
        <div class="form-Registro2">
            <table id="tbGrupos">
                <thead>
                    <tr>
                        <th>Grupo</th>
                        <th>Asiganación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ejecutar as $data) : ?>
                        <tr>
                            <td><?php echo $data['grupo'] ?></td>
                            <td>
                                <?php
                                $query = $con->prepare("SELECT * FROM personal WHERE idPersonal = :idPersonal");
                                $query->bindParam(':idPersonal', $data['idPersonal']);
                                $query->execute();
                                $ejecutar = $query->fetchAll();
                                foreach ($ejecutar as $opciones) : ?>
                                    <option value="<?php echo $opciones['idPersonal'] ?>"><?php echo $opciones['nombres'] ?> <?php echo $opciones['primApellido'] ?> <?php echo $opciones['segApellido']  ?></option>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <a class="edit" href="asignarGrupo.php?id=<?php echo  $data['idGrupo'] ?>"><i class="fa-solid fa-user-gear fa-2x"> </i> Asignar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
    <script>
        var tabla = new DataTable("#tbGrupos", {
            searchable: true,
            fixedColumns: true,
            sortable: false,
            perPage: 5,
            perPageSelect: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });
    </script>
</body>

</html>