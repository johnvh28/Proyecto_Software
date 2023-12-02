<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de usuarios</a></li>
                        <li class="breadcrumb-item active">Monitoreo Usuarios</li>
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
                            <h3 class="card-title">Lista Monitoreo</h3>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Rol</th>
                                        <th>Usuario</th>
                                        <th>MAC</th>
                                        <th>Ip</th>
                                        <th>Navegador</th>
                                        <th>Version del navegador</th>
                                        <th>Dispositivo</th>
                                        <th>Version del dispositivo</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Usuarios['usuarios'] as $usuario) : ?>
                                        <tr>
                                            <td><?php echo $usuario['rol'] ?></td>
                                            <td><?php echo $usuario['usuario'] ?></td>
                                            <td><?php echo $usuario['mac'] ?></td>
                                            <td><?php echo $usuario['ip'] ?></td>
                                            <td><?php echo $usuario['navegador']?></td>
                                            <td><?php echo $usuario['version_navegador'] ?></td>
                                            <td><?php echo $usuario['dispositivo'] ?></td>
                                            <td><?php echo $usuario['version_dispositivo'] ?></td>
                                            <td>
                                                <?php if ($usuario['estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($usuario['estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-warning" style="font: bold 12px Arial, sans-serif; color:white;">Sin verficar</span></span>
                                                <?php elseif ($usuario['estado'] == 3) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <a class="badge rounded-pill bg-gradient-info "><i class="fas fa-ellipsis-v"></i></a>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <?php if ($usuario['estado'] == 2) : ?>
                                                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#Activar<?php echo $usuario['id']; ?>"><i class="fas fa-edit"> </i>Activar usuario</button>
                                                    <?php elseif ($usuario['estado'] == 1) : ?>
                                                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#Eliminar<?php echo $usuario['id']; ?>"><i class="fas  fa-trash"></i>Desconectar session</button>
                                                    <?php endif; ?>
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


    <?php foreach ($Usuarios['usuarios'] as $EliminarUsuario) : ?>

        <div class="modal" tabindex="-1" id="Eliminar<?php echo $EliminarUsuario['id']; ?>">
            <div class="modal-dialog modal-md" style="background-color:red;">
                <div class="modal-content" style="background-color:red;">
                    <div class="modal-header">
                        <h5 style="font: bold 16px Arial, sans-serif; color:black;" class="modal-title" id="myModalTitle">
                            Desactivar usuarios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="crear" name="crear" method="POST" action="index.php?c=login&a=cerrars" autocomplete="off">
                        <div class="modal-body">
                            <h5>¿Estas seguro de cerra la session</h5>
                            <p>
                                El colaborador con este correo ya no podra conectarse de ninguna manera al sistema
                            </p>
                            <input type="text" name="id" value="<?php echo $EliminarUsuario['idUsuario']; ?>" hidden>

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
    <?php foreach ($Usuarios['usuarios'] as $ActivarUsuario) : ?>

        <div class="modal" tabindex="-1" id="Activar<?php echo $ActivarUsuario['id']; ?>">
            <div class="modal-dialog modal-md">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 style="font: bold 16px Arial, sans-serif; color:black;" class="modal-title" id="myModalTitle">
                            Verificar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="crear" name="crear" method="POST" action="index.php?c=usuario&a=EstadoUsuarios&estado=1" autocomplete="off">
                        <div class="modal-body">
                            <h5>¿Estas seguro de verificar este usuario?</h5>
                            <p>
                                El colaborador estara de alta de nuevo en el sistema
                            </p>
                            <input type="text" name="id" value="<?php echo $ActivarUsuario['id']; ?>" hidden>

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

</div>
<?php require_once "view/include/footer_admin.php"; ?>