<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asignaciones de cargos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">Asignaciones</a></li>
                        <li class="breadcrumb-item active">Revertir asignacion cargos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Revertir asignacion Cargos</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=guardarasignacion" autocomplete="off">
                                <div class="card-body">
                                    <div class="card card-cyan">
                                        <img src="assets/img/fotos_Perfil/<?php echo $HistorialCargos['historial']["foto"] ?>" class="profile-user-img img-fluid img-circle">
                                        <div class="card-body">
                                            <h5 class="card-title text-center"><?php echo $HistorialCargos['historial']["nombre"] . ' ' . $HistorialCargos['historial']["apellido"] ?></h5>
                                            <p class="card-text text-center">Codigo: <?php echo $HistorialCargos['historial']["cod_trabajador"] ?></p>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>

                                                <th>cargos</th>
                                                <th>Fecha de registro</th>
                                                <th>Estado</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($HistorialCargos['historial']["cargos"] as $Pago) : ?>
                                                <tr>

                                                    <td><?php echo $Pago['cargo'] ?></td>

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
                                                            <?php if ($Pago['estado'] == 1) : ?>
                                                                <a class="dropdown-item" href="index.php?c=negocio&a=EliminarAsignacion&id=<?php echo $Pago['id']; ?>&estado=2&empleado=<?php echo $Pago['id_empleado']?>"><i class="fas fa-times-circle text-danger"></i>
                                                                    Desactivar asignacion</a>
                                                            <?php elseif ($Pago['estado'] == 2) : ?>
                                                                <a class="dropdown-item" href="index.php?c=negocio&a=EliminarAsignacion&id=<?php echo $Pago['id']; ?>&estado=1&empleado=<?php echo $Pago['id_empleado']?>"><i class="fas fa-check-circle text-success"></i>Activar Asignacion</a>
                                                            <?php endif; ?>

                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once "view/include/footer_admin.php"; ?>