<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Salarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">Salarios</a></li>
                        <li class="breadcrumb-item active">Asignar nuevo Salarios</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Asignar nuevo Salario</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=ActualizarSalarios" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Colaborador:</label>
                                                <input type="text" name="colaborador" value="<?php echo  $Empleado['Salario']['nombre'] . " " . $Empleado['Salario']['apellido'] . " Codigo : " . $Empleado['Salario']['cod_trabajador'] ?>" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Salario:</label>
                                                <input name="salario" type="number" class="form-control" id="salario" value="" required>
                                            </div>
                                        </div>
                                        <?php $id = $_GET['id']; ?>
                                        <input type="text" name="id_salario" value="<?php echo $id ?>" hidden>
                                        <input type="text" name="IdEmpleado" value="<?php echo $Empleado['Salario']['IdEmpleado']  ?>" hidden>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="1">Activo</option>
                                                    <option value="2">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Asignar nuevo Salario</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once "view/include/footer_admin.php"; ?>