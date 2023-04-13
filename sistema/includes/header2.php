<?php

if(empty($_SESSION['active'])){
    header('location: ../');

}

?>
<header>

    <div class="optionsBar">
        <img class="logo" src="/img/image.png">
        <h2>Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"</h2>



    </div>
    <div class="Contenedor-menu">
        <div class="menu">
            <input type="checkbox" id="menu__check">
            <label id="label__check" for="menu__check">
                <i class="fas fa-bars icon__menu"></i>
            </label>

        </div>
    </div>

</header>
