<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Productos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Productos</a></li>
                        <li class="breadcrumb-item active">Productos</li>
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
                            <h3 class="card-title">Lista de Productos</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=productos&a=CrearProducto" class="btn btn-success">Registrar producto</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Categoria</th>
                                        <th>Subcategoria</th>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Foto</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productos['productos'] as $modelos) : ?>
                                        <tr>
                                            <td><?php echo $modelos['categoria'] ?></td>
                                            <td><?php echo $modelos['sub'] ?></td>
                                            <td><?php echo $modelos['codigo'] ?></td>
                                            <td><?php echo $modelos['nombre'] ?></td>
                                            <td><img src="assets/img/productos/<?php echo $modelos['foto'] ?>" alt="" class="img-fluid rounded-circle" style="max-width: 80px;"></td>
                                            <td><?php echo $modelos['descripcion'] ?></td>
                                            <td>
                                                <?php if ($modelos['estado'] == 1) : ?>
                                                    <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                <?php elseif ($modelos['estado'] == 2) : ?>
                                                    <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <a class="badge rounded-pill bg-gradient-info "><i class="fas fa-ellipsis-v"></i></a>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#Activar<?php echo $modelos['id']; ?>"><i class="fas fa-eye"></i>Ver detalles</button>
                                                    <a type="button" class="dropdown-item" href="index.php?c=productos&a=AgregarDetalles&id=<?php echo $modelos['id']; ?>"><i class="fas fa-info-circle"></i>Agregar detalles</a>
                                                    <a class="dropdown-item" href="index.php?c=usuario&a=actualizarproductos&id=<?php echo $modelos['id']; ?>"><i class="fas fa-edit"> </i>Editar</a>

                                                    <a class="dropdown-item" href="index.php?c=usuarioid=<?php echo $modelos['id']; ?>"><i class="fas  fa-trash"></i>Eliminar</a>

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


    <?php foreach ($productos['productos'] as $EliminarModelo) : ?>

        <div class="modal" tabindex="-1" id="Eliminar<?php echo $EliminarModelo['id']; ?>">
            <div class="modal-dialog modal-md" style="background-color:red;">
                <div class="modal-content" style="background-color:red;">
                    <div class="modal-header">
                        <h5 style="font: bold 16px Arial, sans-serif; color:black;" class="modal-title" id="myModalTitle">
                            Desactivar Cargos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="crear" name="crear" method="POST" action="index.php?c=productos&a=EliminarModelo" autocomplete="off">
                        <div class="modal-body">
                            <h5>¿Estas seguro de desactivar este modelo?</h5>
                            <input type="text" name="id" value="<?php echo $EliminarModelo['id']; ?>" hidden>

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