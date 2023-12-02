<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Salarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item active">Salarios</li>
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
                            <h3 class="card-title">Lista de Salarios</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=negocio&a=CrearSalario" class="btn btn-success">Registrar Salario</a>
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
                                        <th>Salarios</th>
                                        <th>Fecha de registro</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Salarios['salarios'] as $Pago) : ?>
                                        <tr>
                                            <td><?php echo $Pago['cod_trabajador'] ?></td>
                                            <td><?php echo $Pago['nombre'] ?></td>
                                            <td><?php echo $Pago['apellido'] ?></td>
                                            <td><?php echo $Pago['salario'] ?></td>
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
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=ActualizarSalario&id=<?php echo $Pago['id_salario']; ?>"><i class="fas fa-edit"></i> Actualizar</a>
                                                    <a class="dropdown-item" href="index.php?c=negocio&a=historialsalario&id=<?php echo $Pago['id']; ?>"> <i class="fas fa-clock"></i> Ver historial de salario</a>
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