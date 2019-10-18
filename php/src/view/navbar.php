<?php
include_once '../boundary/tipo_empleado.php';
include_once '../boundary/empleado.php';
$empleado = new empleado();
$tipoEmpleado =  new tipo_empleado();
$tipo = $tipoEmpleado->getTipoEmpleado($_SESSION['tipoEmpleado']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php" style="padding-right: 30px;  "><img src="img/logo2.png" width="65px" style="padding-right: 15px;" srcset="">Body Master Gym</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php" style="padding-right: 50px; ">DashBoard</a>
            </li>
            <li class="nav-item dropdown active">
                <?php if ($_SESSION['tipoEmpleado'] == 1) { ?>
                    <a class="nav-link dropdown-toggle" href="index.php" id="navbarDropdown" style="padding-right: 50px; " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php } else { ?>
                    <a class="nav-link dropdown-toggle" href="index.php" id="navbarDropdown" style="padding-right: 750px; " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php } ?>
                
                    Miembros
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="registrar-miembro.php">Registrar</a>
                    <a class="dropdown-item" href="miembros.php">Ver todos</a>
                </div>
            </li>
            <?php if ($_SESSION['tipoEmpleado'] == 1) { ?>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" style="padding-right: 50px; " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Empleados
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="registrar-empleado.php">Registrar</a>
                        <a class="dropdown-item" href="empleados.php">Ver todos</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="estadisticas.php" style="padding-right: 25vw" ;>Estadisticas</a>
                </li>
            <?php } ?>

            <li class="nav-item dropdown active" style="float: left;">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" style="float: left;" "role=" button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cuenta
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item">Nombre</a>
                    <a class="dropdown-item" style="cursor: pointer;" onclick="location.href='../controller/loginController.php?close=1';">Cerrar Sesi&oacute;n</a>
                </div>
            </li>
        </ul>

    </div>
</nav>
<br><br>
