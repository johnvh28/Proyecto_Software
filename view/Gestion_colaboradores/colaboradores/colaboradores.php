<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Colaboradores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item active">Colaboradores</li>
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
                            <h3 class="card-title">Lista de Colaboradores</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=negocio&a=CrearColaborador" class="btn btn-success">Registrar colaboradores</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Codigo</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Nombre</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Apellido</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Tipo Identificacion</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Identificacion</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Telefono</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Correo</th>

                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Accion</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Estado</th>

                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Nacionalidad</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Direccion</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Genero</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Foto</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Codigo Inss</th>
                                        <th style="font: bold 16px Arial, sans-serif; color:black;">Fecha de nacimiento</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Colaboradores['colaboradores'] as $empleados) : ?>
                                        <tr>
                                            <td><?php echo $empleados['cod_trabajador'] ?></td>
                                            <td><?php echo $empleados['NombrePersona'] ?></td>
                                            <td><?php echo $empleados['apellido'] ?></td>
                                            <td><?php echo $empleados['tipo_identificacion'] ?></td>
                                            <td><?php echo $empleados['identificacion'] ?></td>
                                            <td><?php echo $empleados['telefono'] ?></td>
                                            <td><?php echo $empleados['correo'] ?></td>
                                            <td>
                                                <div class="btn-list m-2">
                                                    <a class="btn btn-success m-2 " href="index.php?c=negocio&a=actualizarColaborador&id=<?php echo $empleados['IdEmpleado']; ?>">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Eliminar<?php echo $empleados['IdEmpleado']; ?>">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </div>

                                            </td>
                                            <td>
                                                <?php if ($empleados['estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($empleados['estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php endif; ?>
                                            </td>

                                            <td><?php echo $empleados['nacionalidad'] ?></td>
                                            <td><?php echo $empleados['departamento'] . " : " . $empleados['municipio'] . " : " . $empleados['punto']; ?>
                                            </td>
                                            <td><?php echo $empleados['genero'] ?></td>
                                            <td>
                                                <img src="assets/img/fotos_Perfil/<?php echo $empleados['foto'] ?>" alt="" class="img-fluid rounded-circle" style="max-width: 80px;">
                                            </td>

                                            <td><?php echo $empleados['codigo_inss'] ?></td>
                                            <td><?php echo $empleados['fecha_nacimiento'] ?></td>



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


<?php foreach ($Colaboradores['colaboradores'] as $EliminarCargo) : ?>

    <div class="modal" tabindex="-1" id="Eliminar<?php echo $EliminarCargo['IdEmpleado']; ?>">
        <div class="modal-dialog modal-md" style="background-color:red;">
            <div class="modal-content" style="background-color:red;">
                <div class="modal-header">
                    <h5 style="font: bold 16px Arial, sans-serif; color:black;" class="modal-title" id="myModalTitle">Desactivar Cargos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=EliminarColaborador" autocomplete="off">
                    <div class="modal-body">
                        <h5>¿Estas seguro de desactivar este cargo?</h5>
                        <input type="text" name="id" value="<?php echo $EliminarCargo['IdEmpleado']; ?>" hidden>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php require_once "view/include/footer_admin.php"; ?>