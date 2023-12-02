<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Privilegios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de usuarios</a></li>
                        <li class="breadcrumb-item active">Privilegios</li>
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
                            <h3 class="card-title">Lista de roles con privilegios</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=usuario&a=AsignarModulos" class="btn btn-success">Asignar Privilegios</a>
                            </div>

                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Autorizado</th>
                                        <th>Rol</th>
                                        <th>Rol</th>
                                        <th>cantidad modulos</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Usuarios['usuarios'] as $usuario) : ?>
                                        <tr>
                                            <td><?php echo $usuario['autorizado'] ?></td>
                                            <td><?php echo $usuario['grupo'] ?></td>
                                            <td><?php echo $usuario['nombre'] ?></td>
                                            <td><?php echo $usuario['cantidad_modulos_asignados'] ?></td>
                                            <td>
                                                <?php if ($usuario['rol_estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($usuario['rol_estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-warning" style="font: bold 12px Arial, sans-serif; color:white;">Sin verficar</span></span>
                                                <?php elseif ($usuario['rol_estado'] == 3) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <a class="badge rounded-pill bg-gradient-info "><i class="fas fa-ellipsis-v"></i></a>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#Activar<?php echo $usuario['id_usuario']; ?>"><i class="fas fa-eye"></i>Ver privilegios</button>
                                                    <a class="dropdown-item" href="index.php?c=usuario&a=actualizarprivilegios&id=<?php echo $usuario['id_usuario']; ?>"><i class="fas fa-edit"> </i>Agregar nuevo privilegios</a>

                                                    <a class="dropdown-item"  href="index.php?c=usuario&a=eliminarprivilegios&id=<?php echo $usuario['id_usuario']; ?>"><i class="fas  fa-trash"></i>Eliminar</a>

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
    <?php foreach ($Usuarios['usuarios'] as $ActivarUsuario) : ?>

        <div class="modal" tabindex="-1" id="Activar<?php echo $ActivarUsuario['id_usuario']; ?>">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font: bold 16px Arial, sans-serif; color:black;" class="modal-title" id="myModalTitle">
                            Modulos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <?php echo $ActivarUsuario['usuario_modulos_submodulos']; ?>
                        </p>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>
<?php require_once "view/include/footer_admin.php"; ?>