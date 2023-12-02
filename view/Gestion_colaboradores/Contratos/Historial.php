<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contratos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">contratos</a></li>
                        <li class="breadcrumb-item active">Historial contrato empleado</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="assets/img/fotos_Perfil/<?php echo $HistorialSalario['historial']["foto"] ?>" alt="<?php echo  $HistorialSalario['historial']["nombre"] ?>">
                            </div>

                            <h3 class="profile-username text-center"><?php echo $HistorialSalario['historial']["nombre"] . ' ' . $HistorialSalario['historial']["apellido"] ?></h3>

                            <p class="text-muted text-center">Colaborador</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Codigo de trabajador: </b> <a class="text-blue"><?php echo $HistorialSalario['historial']["cod_trabajador"] ?></a>
                                </li>

                            </ul>

                            <a href="index.php?c=negocio&a=contratos" class="btn btn-primary btn-block"><b>Volver Inicio</b></a>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header p-2">
                            <h2>Historial de salarios</h2>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">

                                        <?php
                                        $historialSalarios = $HistorialSalario['historial']["contratos"];

                                        // Número de elementos por página
                                        $elementosPorPagina = 2;

                                        // Número total de páginas
                                        $totalPaginas = ceil(count($historialSalarios) / $elementosPorPagina);

                                        // Página actual, predeterminada a la primera página si no se establece
                                        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                                        // Validar la página actual
                                        if (!is_numeric($paginaActual) || $paginaActual < 1 || $paginaActual > $totalPaginas) {
                                            $paginaActual = 1;
                                        }

                                        // Obtener la porción de datos para la página actual
                                        $inicio = ($paginaActual - 1) * $elementosPorPagina;
                                        $historialPaginado = array_slice($historialSalarios, $inicio, $elementosPorPagina);
                                        ?>

                                        <!-- Mostrar los salarios para la página actual -->
                                        <?php foreach ($historialPaginado as $salario) : ?>
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        Historico de contratos
                                                        <i class="fas fa-clock"></i>
                                                    </h5>
                                                    <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                            <strong>Codigo:</strong> <?php echo $salario['codigo'] ?>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Folio:</strong> <?php echo $salario['tomo'] ?>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Tomo:</strong> <?php echo $salario['folio'] ?>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Contrato:</strong> <a href="assets/contratos/<?php echo $salario['contrato']; ?>" target="_blank"><span class="badge badge-pill badge-info" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $salario['contrato']; ?></span></a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Tipo de contrato:</strong> <?php echo $salario['tipo'] ?>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Estado:</strong>
                                                            <?php if ($salario['estado'] == 1) : ?>
                                                                <strong>Estado:</strong>
                                                                <span class="badge badge-success">
                                                                    Activo
                                                                    <!-- Icono para estado activo -->
                                                                </span>
                                                                <i class="fas fa-check-circle text-success"></i>
                                                            <?php else : ?>
                                                                <strong>Estado:</strong>
                                                                <span class="badge badge-secondary">
                                                                    Inactivo
                                                                </span>
                                                                <i class="fas fa-times-circle text-secondary"></i>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Fecha de Cambio:</strong> <?php echo $salario['fecha_cambio'] ? $salario['fecha_cambio'] : 'N/A' ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                        <!-- Mostrar enlaces de paginación -->
                                        <div class="mt-3">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-center">

                                                    <?php if ($paginaActual > 1) : ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="index.php?c=negocio&a=historialcontrato&id=<?php echo $_GET['id'] ?>&pagina=<?php echo $paginaActual - 1; ?>" aria-label="Previous">
                                                                <span aria-hidden="true">&laquo;</span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                                                        <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                                                            <a class="page-link" href="index.php?c=negocio&a=historialcontrato&id=<?php echo $_GET['id'] ?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                        </li>
                                                    <?php endfor; ?>

                                                    <?php if ($paginaActual < $totalPaginas) : ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="index.php?c=negocio&a=historialcontrato&&id=<?php echo $_GET['id'] ?>&pagina=<?php echo $paginaActual + 1; ?>" aria-label="Next">
                                                                <span aria-hidden="true">&raquo;</span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>

                                                </ul>
                                            </nav>
                                        </div>





                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<?php require_once "view/include/footer_admin.php"; ?>