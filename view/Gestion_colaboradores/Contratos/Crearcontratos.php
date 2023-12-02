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
                        <li class="breadcrumb-item active">Registrar contratos</li>
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
                            <h3 class="card-title">Registrar contratos</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=GuardarContrato" autocomplete="off" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Colaborador:</label>
                                                <select name="id" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <?php foreach ($MostrarColaboradores['colaboradores'] as $contratos) : ?>
                                                        <option value="<?php echo $contratos['id'] ?>"><?php echo "Codigo Empleado:   " . $contratos['cod_trabajador'] .  " Nombre: " . $contratos['nombre'] . " " . $contratos['apellido'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Codigo:</label>
                                                <input name="codigo" type="text" class="form-control" id="folio" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Tomo:</label>
                                                <input name="tomo" type="text" class="form-control" id="folio" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">folio:</label>
                                                <input name="folio" type="number" class="form-control" id="folio" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Fecha de vencimiento:</label>
                                                <input name="fecha" type="date" class="form-control" id="folio" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Contrato:</label>
                                                <div class="custom-file">
                                                    <input type="file" name="contrato" class="custom-file-input" id="customFile" accept=".pdf">
                                                    <label class="custom-file-label" for="customFile">Subir Archivo</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Tipo de contrato:</label>
                                                <select name="tipo" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <?php foreach ($TiposContratos['tipos'] as $salario) : ?>
                                                        <option value="<?php echo $salario['id'] ?>"><?php echo   $salario['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Registrar contrato</button>
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