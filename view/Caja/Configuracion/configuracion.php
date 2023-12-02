<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Configuracion</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Caja</a></li>
                        <li class="breadcrumb-item active">Configuracion</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="row mt-5">
            <div class="col-lg-12 col-sm-6">
                <div class="card mt-5">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!--tabla -->
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Registrar divisa</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Tipos de cambio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Tipos de caja</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings-tipo_denominacion" role="tab" aria-controls="custom-tabs-one-tipo_denominacion" aria-selected="false">Tipos de denominacion</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Moneda Local</span>
                                                <span class="info-box-number"><?php echo $moneda_local ?></span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <?php if (!empty($tipo_cambio['cambios'])) : ?>
                                            <?php foreach ($tipo_cambio['cambios'] as $tipo) : ?>

                                                <div class="info-box">
                                                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Cambio de moneda del dia para <?php echo $tipo['nombre'] ?></span>
                                                        <span class="info-box-number">C$ <?php echo $tipo['cambio'] ?></span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <h5 class="h4 text-blue mb-20">No hay cambio disponible para el dia de hoy</h5>
                                        <?php endif ?>

                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Lista de Divisas</h3>
                                                <div class="align-content-end text-right">
                                                    <a href="index.php?c=caja&a=crear_divisa" class="btn btn-success">Registrar divisa</a>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Simbolo</th>
                                                            <th>Tipo de divisa</th>
                                                            <th>Estado</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($monedas["monedas"]  as $moneda) : ?>
                                                            <tr>
                                                                <td><?php echo $moneda['nombre'] ?></td>
                                                                <td><?php echo $moneda['simbolo'] ?></td>
                                                                <td>
                                                                    <?php if ($moneda['local'] == 1) : ?>
                                                                        <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Divisa local</span></span>
                                                                    <?php elseif ($moneda['local'] == 2) : ?>
                                                                        <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Divisa extrangera</span></span>
                                                                    <?php endif; ?>

                                                                </td>
                                                                <td>
                                                                    <?php if ($moneda['estado'] == 1) : ?>
                                                                        <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                                    <?php elseif ($moneda['estado'] == 2) : ?>
                                                                        <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                                    <?php endif; ?>

                                                                </td>
                                                                <td>
                                                                    <div class="btn-list m-2">
                                                                        <a class="btn btn-success m-2" href="index.php?c=caja&a=actualiza_moneda&id=<?php echo $moneda['id']; ?>">Editar</a>
                                                                        <a class="dropdown-item" href="index.php?c=caja&a=eliminar_monedas&id=<?php echo $moneda['id'] ?>"><i class="dw dw-delete-3"></i>Eliminar</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Tasa de cambio</h3>
                                                <div class="align-content-end text-right">
                                                    <a href="index.php?c=caja&a=subir_tasa_cambio" class="btn btn-success">subir tasa de cambio</a>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Tipo de cambio</th>
                                                            <th>Moneda</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($mostra_cambio["cambio"] as $cambio) : ?>
                                                            <tr>
                                                                <td><?php echo $cambio['fecha'] ?></td>
                                                                <td><?php echo $cambio['cambio'] ?></td>
                                                                <td><?php echo $cambio['nombre'] ?></td>

                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Lista de cajas</h3>
                                                    <div class="align-content-end text-right">
                                                        <a href="index.php?c=caja&a=Vista_crear" class="btn btn-success">Registrar Caja</a>
                                                    </div>

                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Descripcion</th>
                                                                <th>Estado</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($tipos["tipos"] as $tipo) : ?>
                                                                <tr>
                                                                    <td><?php echo $tipo['nombre'] ?></td>
                                                                    <td><?php echo $tipo['descripcion'] ?></td>
                                                                    <td>
                                                                        <?php if ($tipo['estado'] == 1) : ?>
                                                                            <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                                        <?php elseif ($tipo['estado'] == 2) : ?>
                                                                            <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                                        <?php endif; ?>

                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-list m-2">
                                                                            <a class="btn btn-success m-2" href="index.php?c=caja&a=ActualizaTipo&id=<?php echo $tipo['id']; ?>">Editar</a>
                                                                            <a class="dropdown-item" href="index.php?c=caja&a=eliminar_tipo&id=<?php echo $tipo['id'] ?>"><i class="dw dw-delete-3"></i>Eliminar</a>
                                                                        </div>


                                                                    </td>

                                                                </tr>
                                                            <?php endforeach; ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-settings-tipo_denominacion" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tipo_denominacion">

                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Denominacion</h3>
                                                <div class="align-content-end text-right">
                                                    <a href="index.php?c=caja&a=vista_denominacion" class="btn btn-success">crear</a>
                                                </div>

                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Simbolo</th>
                                                            <th>Denominacion</th>
                                                            <th>Estado</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($billetes['billetes'] as $denominacion) : ?>
                                                            <tr>
                                                                <td><?php echo $denominacion['simbolo'] ?></td>
                                                                <td><?php echo $denominacion['denominaciones'] ?></td>
                                                                <td>
                                                                    <?php if ($denominacion['estado'] == 1) : ?>
                                                                        <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                                    <?php elseif ($denominacion['estado'] == 2) : ?>
                                                                        <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                                    <?php endif; ?>

                                                                </td>
                                                                <td>
                                                                    <div class="btn-list m-2">
                                                                        <a class="dropdown-item" href="index.php?c=caja&a=eliminar_denominacion&id=<?php echo $denominacion['id'] ?>"><i class="dw dw-delete-3"></i>Eliminar</a>
                                                                    </div>


                                                                </td>

                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
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