<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mangas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Productos</a></li>
                        <li class="breadcrumb-item"><a href="#">Mangas</a></li>
                        <li class="breadcrumb-item active">Actualizar Manga</li>
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
                            <h3 class="card-title">Actualizar Manga</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=productos&a=ActualizarManga" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input name="nombre" type="text" class="form-control" id="nombre" value="<?php echo   $ActualizacionManga['ActualizacionManga']['nombre'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="descripcion" class="form-label">Descripcion</label>
                                                <input name="descripcion" type="text" class="form-control" id="descripcion" value="<?php echo   $ActualizacionManga['ActualizacionManga']['descripcion'] ?>" required>
                                            </div>
                                        </div>
                                        <input type="text" name="id" value="<?php echo  $ActualizacionManga['ActualizacionManga']['id']; ?>" hidden>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" <?php echo    $ActualizacionManga['ActualizacionManga']['estado'] === '0' ? 'selected' : ''; ?>>Seleccionar</option>
                                                    <option value="1" <?php echo    $ActualizacionManga['ActualizacionManga']['estado'] === '1' ? 'selected' : ''; ?>>Activo</option>
                                                    <option value="2" <?php echo    $ActualizacionManga['ActualizacionManga']['estado'] === '2' ? 'selected' : ''; ?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Actualizar manga</button>
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