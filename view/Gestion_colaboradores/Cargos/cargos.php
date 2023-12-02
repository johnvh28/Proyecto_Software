<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cargos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item active">Cargos</li>
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
                            <h3 class="card-title">Lista de Cargos</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=negocio&a=Crearcargos" class="btn btn-success">Registrar cargo</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Cargo</th>
                                        <th>Perfil</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($CargosLista['Listas'] as $cargos) : ?>
                                        <tr>
                                            <td><?php echo $cargos['codigo'] ?></td>
                                            <td><?php echo $cargos['nombre'] ?></td>
                                            <td><?php echo $cargos['perfil'] ?></td>
                                            <td><?php echo $cargos['descripcion'] ?></td>
                                            <td>
                                                <?php if ($cargos['estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($cargos['estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <div class="btn-list m-2">
                                                    <a class="btn btn-success m-2" href="index.php?c=negocio&a=actualizarcargos&id=<?php echo $cargos['id']; ?>">Editar</a>
                                                    <button type="button" class="btn btn-danger m-2" data-toggle="modal" data-target="#Eliminar<?php echo $cargos['id']; ?>">Eliminar</button>
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


    <?php foreach ($CargosLista['Listas'] as $EliminarCargo) : ?>

        <div class="modal" tabindex="-1" id="Eliminar<?php echo $EliminarCargo['id']; ?>">
            <div class="modal-dialog modal-md" style="background-color:red;">
                <div class="modal-content" style="background-color:red;">
                    <div class="modal-header">
                        <h5 style="font: bold 16px Arial, sans-serif; color:black;" class="modal-title" id="myModalTitle">
                            Desactivar Cargos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=EliminarCargo" autocomplete="off">
                        <div class="modal-body">
                            <h5>¿Estas seguro de desactivar este cargo?</h5>
                            <input type="text" name="id" value="<?php echo $EliminarCargo['id']; ?>" hidden>

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