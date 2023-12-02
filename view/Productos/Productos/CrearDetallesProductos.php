<?php require_once "view/include/header_admin.php" ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Detalle de productos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Productos</a></li>
                        <li class="breadcrumb-item active">Detalles Productos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="">
        <article class="col-xl-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Colores</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Mangas</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Tallas</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settingsmodelos" data-toggle="tab">Modelos</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settingsprecio" data-toggle="tab">Precios</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div class="align-content-end text-right">
                                        <a href="index.php?c=productos&a=aggcolor&id=<?php echo $_GET['id'] ?>" class="btn btn-success">Registrar Color</a>
                                    </div>


                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Color</th>
                                                <th>Foto</th>
                                                <th>Estado</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productosC['productoC'] as $pcolor) : ?>
                                                <tr>
                                                    <td><?php echo $pcolor['nombre_producto'] ?></td>
                                                    <td><?php echo $pcolor['nombre_color'] ?></td>
                                                    <td><img src="assets/img/productos/<?php echo $pcolor['foto'] ?>" alt="" class="img-fluid rounded-circle" style="max-width: 80px;"></td>

                                                    <td>
                                                        <?php if ($pcolor['estado'] == 1) : ?>
                                                            <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                        <?php elseif ($pcolor['estado'] == 2) : ?>
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

                                <div class="tab-pane" id="timeline">

                                    <div class="align-content-end text-right">
                                        <a href="index.php?c=productos&a=aggmanga&id=<?php echo $_GET['id'] ?>" class="btn btn-success">Registrar Manga</a>
                                    </div>


                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Manga</th>
                                                <th>Foto</th>
                                                <th>Estado</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productosManga['productoManga'] as $pmanga) : ?>
                                                <tr>
                                                    <td><?php echo $pmanga['nombre_producto'] ?></td>
                                                    <td><?php echo $pmanga['nombre_manga'] ?></td>
                                                    <td><img src="assets/img/productos/<?php echo $pmanga['foto'] ?>" alt="" class="img-fluid rounded-circle" style="max-width: 80px;"></td>

                                                    <td>
                                                        <?php if ($pmanga['estado'] == 1) : ?>
                                                            <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                        <?php elseif ($pmanga['estado'] == 2) : ?>
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

                                    <div class="timeline timeline-inverse">


                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <div class="align-content-end text-right">
                                        <a href="index.php?c=productos&a=aggtalla&id=<?php echo $_GET['id'] ?>" class="btn btn-success">Registrar Talla</a>
                                    </div>


                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Talla</th>
                                                <th>Foto</th>
                                                <th>Estado</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productosT['productoT'] as $ptalla) : ?>
                                                <tr>
                                                    <td><?php echo $ptalla['nombre_producto'] ?></td>
                                                    <td><?php echo $ptalla['nombre_talla'] ?></td>
                                                    <td><img src="assets/img/productos/<?php echo $ptalla['foto'] ?>" alt="" class="img-fluid rounded-circle" style="max-width: 80px;"></td>

                                                    <td>
                                                        <?php if ($ptalla['estado'] == 1) : ?>
                                                            <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                        <?php elseif ($ptalla['estado'] == 2) : ?>
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
                                <div class="tab-pane" id="settingsmodelos">

                                    <div class="align-content-end text-right">
                                        <a href="index.php?c=productos&a=aggmodelo&id=<?php echo $_GET['id'] ?>" class="btn btn-success">Registrar Modelo</a>
                                    </div>


                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Modelo</th>
                                                <th>Foto</th>
                                                <th>Estado</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productosModelo['productoModelo'] as $pmodelo) : ?>
                                                <tr>
                                                    <td><?php echo $pmodelo['nombre_producto'] ?></td>
                                                    <td><?php echo $pmodelo['nombre_modelo'] ?></td>
                                                    <td><img src="assets/img/productos/<?php echo $pmodelo['foto'] ?>" alt="" class="img-fluid rounded-circle" style="max-width: 80px;"></td>

                                                    <td>
                                                        <?php if ($pmodelo['estado'] == 1) : ?>
                                                            <span class="badge rounded-pill bg-success" style="font: bold 12px Arial, sans-serif; color:white;">Activo</span></span>
                                                        <?php elseif ($pmodelo['estado'] == 2) : ?>
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
                                <div class="tab-pane" id="settingsprecio">
                                    <div class="align-content-end text-right">
                                        <a href="index.php?c=productos&a=aggprecio&id=<?php echo $_GET['id'] ?>" class="btn btn-success">Registrar Precio</a>
                                    </div>


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
            </div>
        </article>
    </section>
</div>

<?php require_once "view/include/footer_admin.php" ?>