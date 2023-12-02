<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestion de caja</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de caja</a></li>
                        <li class="breadcrumb-item active">Caja</li>
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
                            <h3 class="card-title">Lista de caja</h3>
                            <div class="align-content-end text-right">
                                <a href="index.php?c=caja&a=crear_caj" class="btn btn-success">Crear</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Tipo de caja</th>
                                        <th>Caja</th>
                                        <th>Creado por </th>
                                        <th>Fecha de registro</th>
                                        <th>Estado</th>
                                        <th class="datatable-nosort"> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['caja'] as $row) : ?>
                                        <tr>
                                            <td><?php echo $row['caja_id'] ?></td>
                                            <td><?php echo $row['tipo_caja_nombre'] ?></td>
                                            <td class="table-plus"><?php echo $row['NOMBRE_CAJA'] ?></td>
                                            <td><?php echo $row['trabajador_nombre'] ?></td>
                                            <td><?php echo $row['caja_fecha_registro'] ?></td>
                                            <td>
                                                <?php
                                                $estado = $row['caja_estado'];
                                                $estado_texto = '';
                                                $estado_color = '';

                                                switch ($estado) {
                                                    case 1:
                                                        $estado_texto = 'Activo';
                                                        $estado_color = '#265ed7'; // Clase CSS para color azul
                                                        break;
                                                    case 2:
                                                        $estado_texto = 'Inactivo';
                                                        $estado_color = '#e95959'; // Clase CSS para color rojo
                                                        break;
                                                    case 3:
                                                        $estado_texto = 'En proceso de apertura';
                                                        $estado_color = '#FFD700'; // Clase CSS para color amarillo
                                                        break;
                                                    case 4:
                                                        $estado_texto = 'Aperturada';
                                                        $estado_color = ' #00FF00'; // Clase CSS para color verde
                                                        break;
                                                    case 5:
                                                        $estado_texto = 'En arqueo';
                                                        $estado_color = '#FF4500'; // Clase CSS para color celeste
                                                        break;
                                                    default:
                                                        $estado_texto = 'Desconocido';
                                                        $estado_color = 'badge-secondary'; // Clase CSS para color gris
                                                }

                                                echo "<span class='badge badge-pill' data-bgcolor='#e7ebf5' data-color='$estado_color'>$estado_texto</span>";
                                                ?>

                                            </td>
                                            <td>
                                                <div class='dropdown'>
                                                    <a class='btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle' href='#' role='button' data-toggle='dropdown'>
                                                        <i class='dw dw-more'></i></a>
                                                    <div class='dropdown-menu dropdown-menu-right dropdown-menu-icon-list' aria-labelledby='dropdownMenuButton'>
                                                        <a class='dropdown-item' href=''><i class='dw dw-eye'></i> Ver</a>

                                                        <?php

                                                        foreach ($_SESSION['permisos'] as $permiso) {
                                                            if ($permiso['id_permiso'] == 3 && $permiso['id_modulo'] == 5) {
                                                                echo "<a class='dropdown-item' href='index.php?c=caja&a=caja_eliminar&id=" .  $row['caja_id'] . "'><i class='dw dw-delete-3'></i>Cancelar</a>";
                                                            }
                                                            if ($permiso['id_permiso'] == 3 && $permiso['id_modulo'] == 5) {
                                                                echo "<a class='dropdown-item' href='index.php?c=caja&a=caja_actualizar&id=" .  $row['caja_id'] . "'><i class='dw dw-edit2'></i>Editar</a>";
                                                            }
                                                        }

                                                        ?>

                                                    </div>
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