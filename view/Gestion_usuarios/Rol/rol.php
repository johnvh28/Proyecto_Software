<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Roles de usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de usuarios</a></li>
                        <li class="breadcrumb-item active">Roles</li>
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
                            <h3 class="card-title">Lista de roles</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=usuario&a=CrearRol" class="btn btn-success">Registrar rol</a>
                            </div>

                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Perfil</th>
                                        <th>Codigo</th>
                                        <th>Rol</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Roles['rol'] as $rol) : ?>
                                        <tr>
                                             <td><?php echo $rol['perfil'] ?></td>
                                            <td><?php echo $rol['codigo'] ?></td>
                                            <td><?php echo $rol['nombre'] ?></td>
                                            <td><?php echo $rol['descripcion'] ?></td>
                                            <td>
                                                <?php if ($rol['estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($rol['estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <a class="badge rounded-pill bg-gradient-info "><i class="fas fa-ellipsis-v"></i></a>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="index.php?c=usuario&a=ActualizarRol&id=<?php echo $rol['id']; ?>"><i class="fas fa-edit"> </i>Actualizar</a>
                                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#Eliminar<?php echo $rol['id']; ?>"><i class="fas  fa-trash"></i>Eliminar</button>
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


    <?php foreach ($Roles['rol'] as $EliminarRol) : ?>

        <div class="modal" tabindex="-1" id="Eliminar<?php echo $EliminarRol['id']; ?>">
            <div class="modal-dialog modal-md" style="background-color:red;">
                <div class="modal-content" style="background-color:red;">
                    <div class="modal-header">
                        <h5 style="font: bold 16px Arial, sans-serif; color:black;" class="modal-title" id="myModalTitle">
                            Desactivar Rol</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="crear" name="crear" method="POST" action="index.php?c=usuario&a=EliminarRol" autocomplete="off">
                        <div class="modal-body">
                            <h5>¿Estas seguro de desactivar este rol?</h5>
                            <p>
                                Los usuarios con este rol no van poder inciar session en el sistema
                            </p>
                            <input type="text" name="id" value="<?php echo $EliminarRol['id']; ?>" hidden>

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