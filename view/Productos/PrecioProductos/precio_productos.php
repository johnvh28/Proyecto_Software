<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Precio de Productos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Productos</a></li>
                        <li class="breadcrumb-item active">Precio de Productos</li>
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
                                <a href="index.php?c=productos&a=aggprecio" class="btn btn-success">Registrar Precio</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio de compra</th>
                                        <th>Margen de ganancia</th>
                                        <th>Precio de venta</th>
                                        <th>Fecha de registro</th>
                                        <th>Estado</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                            <?php foreach ($productosPrecio['precio'] as $pprecio) : ?>
                                                <tr>
                                                    <td><?php echo $pprecio['nombre_producto'] ?></td>
                                                    <td><?php echo $pprecio['precio_compra'] ?></td>
                                                    <td><?php echo $pprecio['margen_ganancia'] ?></td>
                                                    <td><?php echo $pprecio['precio_venta'] ?></td>
                                                    <td><?php echo $pprecio['fecha_registro'] ?></td>

                                                    <td>
                                                        <?php if ($pprecio['estado'] == 1) : ?>
                                                            <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                        <?php elseif ($pprecio['estado'] == 2) : ?>
                                                            <span class="badge rounded-pill bg-danger" style="font: bold 12px Arial, sans-serif; color:white;">Inactivo</span></span>
                                                        <?php endif; ?>

                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <a class="badge rounded-pill bg-gradient-info "><i class="fas fa-ellipsis-v"></i></a>
                                                        </button>
                                                        <div class="dropdown-menu">
                   
                                                        
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

</div>

<?php require_once "view/include/footer_admin.php"; ?>