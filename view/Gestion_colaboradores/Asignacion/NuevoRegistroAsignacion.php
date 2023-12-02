<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asignaciones de cargos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">Asignaciones</a></li>
                        <li class="breadcrumb-item active">Asignar cargos</li>
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
                            <h3 class="card-title">Asignar Cargos</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=guardarasignacion" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Colaborador:</label>
                                                <input type="text" class="form-control" Value="<?php echo $nombre.' ' .$apellido ?>">
                                            <input type="text" name="id" value="<?php echo $_GET['id'] ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Cargos:</label>
                                                <select class="select2bs4" name="cargos_seleccionados[]" multiple="multiple" data-placeholder="Seleccionar cargos" style="width: 100%;">
                                                    <?php foreach (  $CargosLista['Listas'] as $salario) : ?>
                                                        <option value="<?php echo $salario['id'] ?>"><?php echo $salario['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select name="estado" data-placeholder="Seleccionar estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                  
                                                    <option value="1">Activo</option>
                                                    <option value="2">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Asignar</button>
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