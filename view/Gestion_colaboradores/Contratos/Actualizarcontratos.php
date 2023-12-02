<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contratos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">Contratos</a></li>
                        <li class="breadcrumb-item active">Actualizar Contrato</li>
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
                            <h3 class="card-title">Actualizar contratos</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=ActualizarContratos" autocomplete="off" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Colaborador:</label>
                                                <input type="text" class="form-control" value="<?php echo $Contrato['actualizar']['nombre']. ' '. $Contrato['actualizar']['apellido'].' '. 'Codigo: '. $Contrato['actualizar']['cod_trabajador']; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Codigo:</label>
                                                <input name="codigo" type="text" class="form-control" id="folio" value="<?php echo $Contrato['actualizar']['codigo'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Tomo:</label>
                                                <input name="tomo" type="text" class="form-control" id="folio" value="<?php echo $Contrato['actualizar']['tomo'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">folio:</label>
                                                <input name="folio" type="number" class="form-control" id="folio" value="<?php echo $Contrato['actualizar']['folio'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Fecha de vencimiento:</label>
                                                <input name="fecha" type="date" class="form-control" id="folio" value="<?php echo $Contrato['actualizar']['fecha_vencimiento'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Contrato:</label>
                                                <div class="custom-file">
                                                    <input type="file" name="contrato" class="custom-file-input" id="customFile" accept=".pdf">
                                                    <label class="custom-file-label" for="customFile">Subir Archivo</label>
                                                </div>
                                                <input type="text" name="id_empleado" value="<?php echo $Contrato['actualizar']['id_empleado'] ?>"hidden>
                                                <input type="text" name="id" value="<?php echo $Contrato['actualizar']['id'] ?>" hidden>
                                                <input type="text" name="contratoA" value="<?php echo $Contrato['actualizar']['contrato'] ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Tipo de contrato:</label>
                                                <select name="tipo" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <?php foreach ($TiposContratos['tipos'] as $salario) : ?>
                                                        <option value="<?php echo $salario['id'] ?>"  <?php echo  $salario['id'] === $Contrato['actualizar']['id_tipo'] ? 'selected' : ''; ?>><?php echo   $salario['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Estado" class="form-label">Estado:</label>
                                                <select name="estado" id=""  class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                <option value="1"  <?php  echo $Contrato['actualizar']['estado'] === '1' ? 'selected' : ''; ?>>Activo</option>
                                                <option value="2"  <?php  echo $Contrato['actualizar']['estado'] === '2' ? 'selected' : ''; ?>>Inactivo</option>
                                                <option value="3"  <?php  echo $Contrato['actualizar']['estado'] === '3' ? 'selected' : ''; ?>>Vencido</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Actualizar Contrato</button>
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