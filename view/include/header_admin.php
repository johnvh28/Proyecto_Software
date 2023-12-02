<?php
require_once "model/login.php";
$lifetime = 60 * 60 * 8; // 8 horas en segundos


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['last_activity'])) {

    $_SESSION['last_activity'] = time();
} elseif (time() - $_SESSION['last_activity'] > $lifetime) {
    // La duración de la cookie ha expirado, se cierra la sesión
    session_unset();
    session_destroy();

    // Redirecciona a la página de cierre de sesión
    header("Location: index.php?c=login&a=cerrar_session&id=" . $_SESSION['IdUsuario']);
    exit();
}

// Actualiza la marca de tiempo de la última actividad
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['nombre'])) {
    header('Location: index.php?c=page');
}

if ($_SESSION['verificar'] == 2 && isset($_SESSION['codigo'])) {
    header("Location: index.php?c=page");
    exit();
}

if (isset($_SESSION['nombre'], $_SESSION['foto'], $_SESSION['IdUsuario'])) {
    // Acceder a las claves 'nombre', 'foto' y 'submodulo' y utilizar sus valores
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $foto = $_SESSION['foto'];
    $IdUsuario = $_SESSION['IdUsuario'];
    $CodigoTrabajador = $_SESSION['codigo'];
}

if (isset($_SESSION['mensaje'])) {
    echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "' . $_SESSION['tipo'] . '",
                title: "Mensaje",
                text: "' . $_SESSION['mensaje'] . '"
            });
        });
    </script>';
    unset($_SESSION['mensaje'], $_SESSION['tipo']);
}

/** Mantener actualizados los privilegios */
$loginModel = new Login_Model();
$_SESSION['privilegios'] = $loginModel->ObtenerPrivilegio($_SESSION['IdUsuario']);
$_SESSION['privilegiosTemporales'] = $loginModel->ObtenerPrivilegioTemporales($_SESSION['IdUsuario']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIRCOMD</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/admin/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?c=page&a=inicio" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Contacto</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=login&a=cerrar&id=<?php echo  $_SESSION['IdUsuario'] ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout

                    </a>

                </li>

            </ul>


        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar bg-dark elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="assets/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SIRCOMD</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="assets/img/fotos_perfil/<?php echo $_SESSION['foto'] ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] ?></a>
                    </div>
                </div>


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php foreach ($_SESSION['privilegios'] as $modulo) : ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas <?php echo $modulo['icono']; ?>"></i>
                                    <p>
                                        <?php echo $modulo['nombre']; ?>
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <?php if (!empty($modulo['submodulos'])) : ?>
                                    <ul class="nav nav-treeview">
                                        <!-- Iteración del arreglo de submódulos para construir los elementos del menú -->
                                        <?php foreach ($modulo['submodulos'] as $submodulo) : ?>
                                            <li class="nav-item">
                                                <a href="<?php echo $submodulo['enlace']; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $submodulo['nombre']; ?></p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                        <?php foreach ($_SESSION['privilegiosTemporales'] as $modulo) : ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas <?php echo $modulo['icono']; ?>"></i>
                                    <p>
                                        <?php echo $modulo['nombre']; ?>
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <?php if (!empty($modulo['submodulos'])) : ?>
                                    <ul class="nav nav-treeview">
                                        <!-- Iteración del arreglo de submódulos para construir los elementos del menú -->
                                        <?php foreach ($modulo['submodulos'] as $submodulo) : ?>
                                            <li class="nav-item">
                                                <a href="<?php echo $submodulo['enlace']; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $submodulo['nombre']; ?></p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- /.card -->
