<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asignaciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item active">Asignaciones</li>
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
                            <h3 class="card-title">Lista de Asignacion de cargos</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=negocio&a=crearasignacion" class="btn btn-success">Registrar Asignacion</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Numeros de cargos</th>
                                        <th>Fecha de registro</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($AsignacionCargos['cargos'] as $Pago) : ?>
                                        <tr>
                                            <td><?php echo $Pago['cod_trabajador'] ?></td>
                                            <td><?php echo $Pago['nombre'] ?></td>
                                            <td><?php echo $Pago['apellido'] ?></td>
                                            <td><?php echo $Pago['numeros'] ?></td>

                                            <td><?php echo $Pago['fecha_registro'] ?></td>
                                            <td>
                                                <?php if ($Pago['estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($Pago['estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <a class="badge rounded-pill bg-gradient-info "><i class="fas fa-ellipsis-v"></i></a>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=nuevaasignacion&id=<?php echo $Pago['id_empleado']; ?>"><i class="fas fa-edit"> </i>Registrar nueva asignacion</a>
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=revetirasignacion&id=<?php echo $Pago['id_empleado']; ?>"><i class="fas fa-undo"> </i>Revetir asignaciones</a>
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=historialasignacion&id=<?php echo $Pago['id_empleado']; ?>"> <i class="fas fa-clock"></i> Ver historial de asignaciones</a>
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