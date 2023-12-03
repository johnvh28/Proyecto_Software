<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Apertura</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Caja</a></li>
                        <li class="breadcrumb-item active">Apertura</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">

                <!--tabla -->
                <div class="row">
                    <div class="col-lg-12 col-sm-6">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Lista de apertura</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Solicitar apertura</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Gestion de apertura</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Lista de apertura</h3>
                                                <div class="align-content-end text-right">
                                                    <a href="index.php?c=caja&a=crear_apertura" class="btn btn-success">Crear</a>
                                                </div>

                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">

                                                    <thead>
                                                        <tr>
                                                            <th class="table-plus datatable-nosort">Codigo</th>
                                                            <th>Caja</th>
                                                            <th>Aperturado</th>
                                                            <th>Autorizado</th>
                                                            <th>Fecha de apertura</th>
                                                            <th>Monto de efectivo</th>

                                                            <th>Estado</th>
                                                            <th class="datatable-nosort">Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($data['apertura'] as $row) { ?>
                                                            <tr>
                                                                <td class="table-plus">
                                                                    <?php echo $row['id']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['tipo_caja']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['trabajador']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['autorizado_por']; ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo $row['fecha_apertura']; ?>
                                                                </td>

                                                                <td>
                                                                    <?php echo $row['monto']; ?>
                                                                </td>


                                                                <td>
                                                                    <?php
                                                                    if ($row['estado'] == 1) {
                                                                        echo "<span class='badge badge-pill' data-bgcolor='#e7ebf5' data-color='#265ed7'>Solicitando</span>";
                                                                    } elseif ($row['estado'] == 2) {
                                                                        echo "<span class='badge badge-pill' data-bgcolor='#e7ebf5' data-color='#265ed8'>Inactivo</span>";
                                                                    } elseif ($row['estado'] == 3) {
                                                                        echo "<span class='badge badge-pill' data-bgcolor='#e7ebf5' data-color='#e95959'>Inactivo</span>";
                                                                    }
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
                                                                                    echo "<a class='dropdown-item' href=''><i class='dw dw-delete-3'></i>Cancelar</a>";
                                                                                }
                                                                                if ($permiso['id_permiso'] == 4 && $permiso['id_modulo'] == 5) {
                                                                                    echo "";
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                                        <div class="row clearfix">
                                            <?php foreach ($caja["caja"] as $producto) : ?>
                                                <div class="col-md-4 col-sm-12 mb-30">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Caja:</h5>

                                                            <a href="#" class="btn-block" data-toggle="modal" data-target="#modal-<?php echo $producto['caja_id']; ?>" type="button">
                                                                <?php echo $producto['tipo_caja_nombre']; ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade bs-example-modal-lg" id="modal-<?php echo $producto['caja_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel" style="font: bold 16px Arial, sans-serif;">
                                                                        Solicitud de caja
                                                                    </h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        ×
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <label for="" style="font: bold 16px Arial, sans-serif;">Caja:</label>
                                                                    <?php echo $producto['tipo_caja_nombre']; ?>
                                                                    <br>
                                                                    <label for="" style="font: bold 16px Arial, sans-serif;">Nombre:</label>
                                                                    <?php echo $producto['NOMBRE_CAJA']; ?>
                                                                    <br>

                                                                    <label for="" style="font: bold 16px Arial, sans-serif;">Dia que se
                                                                        registro:</label>
                                                                    <?php echo $producto['caja_fecha_registro']; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <?php if ($producto["caja_estado"] == 1) : ?>
                                                                        <a type="button" style="font: bold 16px Arial, sans-serif; color:white;" href="index.php?c=caja&a=crear_apertura&id=<?php echo $producto['caja_id']; ?>" class="btn btn-primary">
                                                                            Solicitar apertura
                                                                        </a>
                                                                    <?php elseif ($producto["caja_estado"] == 2) : ?>
                                                                        <?php foreach ($data['apertura'] as $row) { ?>
                                                                            <?php if (empty($row['monto_cordobas']) && empty($row['monto_dolares'])) : ?>
                                                                                <a type="button" style="font: bold 16px Arial, sans-serif; color:white;" href="index.php?c=caja&a=asignar_montos&id=<?php echo $row['id']; ?>" class="btn btn-success">
                                                                                    Registrar montos
                                                                                </a>
                                                                            <?php endif; ?>

                                                                        <?php } ?>
                                                                    <?php elseif ($producto["caja_estado"] == 3) : ?>
                                                                        <a type="button" style="font: bold 16px Arial, sans-serif; color:white;" href="" class="btn btn-danger">
                                                                            Tu solicitud ha sido rechazada
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages">
                                        <div class="row clearfix">
                                            <?php foreach ($aperturar['solicitud'] as $apertura) : ?>
                                                <div class="col-md-4 col-sm-12 mb-30">
                                                    <div class="pd-20 card-box height-100-p">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title">Solicitud de apertura</h5>
                                                                <a href="#" class="btn-block" data-toggle="modal" data-target="#modal-apertura-<?php echo $apertura['id']; ?>" type="button">
                                                                    <?php echo $apertura['tipo_caja']; ?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade bs-example-modal-lg" id="modal-apertura-<?php echo $apertura['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myLargeModalLabel" style="font: bold 16px Arial, sans-serif;">
                                                                            Solicitud de apertura
                                                                        </h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                            ×
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label class="font-weight-bold">Tipo de caja:</label>
                                                                                <?php echo $apertura['tipo_caja']; ?>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="font-weight-bold">Caja:</label>
                                                                                <?php echo $apertura['caja']; ?>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="font-weight-bold">Solicitante:</label>
                                                                                <?php echo $apertura['nombre_trabajador']; ?>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <strong class="font-weight-bold">Detalle de los montos de apertura:</strong>
                                                                                <br>
                                                                                <?php foreach ($apertura['detalles'] as $detalle) : ?>
                                                                                    <label class="font-weight-bold"><?php echo $detalle['divisa']; ?>:</label>
                                                                                    <label><?php echo $detalle['total_divisa']; ?></label><br>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <?php if ($apertura["estado"] == 1) : ?>
                                                                            <a type="button" style="font: bold 16px Arial, sans-serif; color:white;" href="index.php?c=caja&a=autorizacion_apertura&id=<?php echo $apertura['id']; ?>&id_trabajador=<?php echo $id_trabajador ?>&estado=<?php echo $estado = 2; ?>&caja=<?php echo $apertura['id_caja'] ?>" class="btn btn-primary">
                                                                                Aceptar Solicitud
                                                                            </a>
                                                                            <a type="button" style="font: bold 16px Arial, sans-serif; color:white;" href="index.php?c=caja&a=autorizacion_apertura&id=<?php echo $apertura['id']; ?>&id_trabajador=<?php echo $id_trabajador ?>&estado=<?php echo $estado = 3; ?>&caja=<?php echo $apertura['id_caja'] ?>" class="btn btn-danger ">
                                                                                Rechazar solicitud
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once "view/include/footer_admin.php"; ?>