<?php

$usuario = $_SESSION['usuario'];
$idEmpleado = $_SESSION['idUsuario'];
if (empty($_SESSION['active'])) {
    header('location: ../');
}

?>
<header>

    <div class="optionsBar">
        <img class="logo" src="../img/image.png">
        <h2>Sistema Integral de Información Estudiantil</h2>
        <span>|</span>

        <p class="reloj">H. Matamoros a <?= fechaC() ?> </p>
        <span>|</span>
        <span class="user">Usuario: <?php echo $_SESSION['usuario']; ?></span>
        <img class="photouser" src="img/user.png" alt="Usuario">
        <a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
    </div>
    <div class="Contenedor-menu">
        <div class="menu">
            <input type="checkbox" id="menu__check">
            <label id="label__check" for="menu__check">
                <i class="fas fa-bars icon__menu"></i>
            </label>
            <?php include("nav.php"); ?>
        </div>
    </div>

</header>