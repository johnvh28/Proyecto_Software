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
                        <li class="breadcrumb-item active">Contratos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Contratos</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=negocio&a=CrearContrato" class="btn btn-success">Registrar Contrato</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Tomo</th>
                                        <th>Folio</th>
                                        <th>Tipo de contrato</th>
                                        <th>Contrato</th>
                                        <th>Codigo Trabajador</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Fecha de registro</th>
                                        <th>Estado</th>
                                        <th>Fecha de vencimiento</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($MostrarContratos['contratos'] as $contratos) : ?>
                                        <tr>
                                            <td><?php echo $contratos['codigo'] ?></td>
                                            <td><?php echo $contratos['tomo'] ?></td>
                                            <td><?php echo $contratos['folio'] ?></td>
                                            <td><?php echo $contratos['tipo_contrato'] ?></td>
                                            <td><a href="assets/contratos/<?php echo $contratos['contrato']; ?>" target="_blank"><span class="badge badge-pill badge-info" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $contratos['contrato']; ?></span></a></td>
                                            <td><?php echo $contratos['cod_trabajador'] ?></td>
                                            <td><?php echo $contratos['nombre'] ?></td>
                                            <td><?php echo $contratos['apellido'] ?></td>
                                            <td><?php echo $contratos['fecha_registro'] ?></td>
                                            <td>
                                                <?php if ($contratos['estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($contratos['estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php elseif ($contratos['estado'] == 3) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Vencido</span></span>
                                                <?php endif; ?>

                                            </td>
                                            <td><?php echo $contratos['fecha_vencimiento'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <a class="badge rounded-pill bg-gradient-info "><i class="fas fa-ellipsis-v"></i></a>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=ActualizarContrato&id=<?php echo $contratos['id']; ?>"><i class="fas fa-edit"></i> Actualizar</a>
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=RegistrarContrato&id=<?php echo $contratos['empleado']; ?>"><i class="fas fa-edit"></i>Registrar Nuevo contrato</a>
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=historialcontrato&id=<?php echo $contratos['empleado']; ?>"> <i class="fas fa-clock"></i> Ver historial de contratos</a>
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
    </section>

</div>

<?php require_once "view/include/footer_admin.php"; ?>