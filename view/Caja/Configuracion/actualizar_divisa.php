<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Divisa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Configuracion</a></li>
                        <li class="breadcrumb-item"><a href="#">Divisa</a></li>
                        <li class="breadcrumb-item active">Actualizar divisa</li>
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
                            <h3 class="card-title">Actualizar divisa</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=caja&a=actualizar_moneda" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input name="nombre" type="text" class="form-control" id="nombre" value="<?php echo $Actualizaciondivisa['Actualizacion']['nombre'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="descripcion" class="form-label">simbolo</label>
                                                <input name="simbolo" type="text" class="form-control" id="simbolo" value="<?php echo $Actualizaciondivisa['Actualizacion']['simbolo'] ?>" required>
                                            </div>
                                        </div>
                                        <input type="text" name="id" value="<?php echo $Actualizaciondivisa['Actualizacion']['id']; ?>" hidden>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="local" class="form-label">Tipo de divisa</label>
                                                <select name="local" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" <?php echo  $Actualizaciondivisa['Actualizacion']['local'] === '0' ? 'selected' : ''; ?>>Seleccionar</option>
                                                    <option value="1" <?php echo  $Actualizaciondivisa['Actualizacion']['local'] === '1' ? 'selected' : ''; ?>>Moneda local</option>
                                                    <option value="2" <?php echo  $Actualizaciondivisa['Actualizacion']['local'] === '2' ? 'selected' : ''; ?>>Moneda extrangera</option>
                                                </select>
                                            </div>
                                        </div> 

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" <?php echo  $Actualizaciondivisa['Actualizacion']['estado'] === '0' ? 'selected' : ''; ?>>Seleccionar</option>
                                                    <option value="1" <?php echo  $Actualizaciondivisa['Actualizacion']['estado'] === '1' ? 'selected' : ''; ?>>Activo</option>
                                                    <option value="2" <?php echo  $Actualizaciondivisa['Actualizacion']['estado'] === '2' ? 'selected' : ''; ?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>                                       

                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Actualizar divisa</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
    </section>
</div>
<?php require_once "view/include/footer_admin.php"; ?>