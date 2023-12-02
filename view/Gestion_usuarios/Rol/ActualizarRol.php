<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rol</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">Rol</a></li>
                        <li class="breadcrumb-item active">Actualizar Rol</li>
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
                            <h3 class="card-title">Actualizar Rol</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=usuario&a=ActualizacionRol" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Perfil</label>
                                                <select name="perfil" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                <?php foreach ( $Roless["perfil"] as $Generos) : ?>
                                                        <option value="<?php echo $Generos['id']; ?>" <?php echo $Generos['id'] === $Roles['roles']['id_perfil'] ? 'selected' : ''; ?>><?php echo $Generos['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="id" value="<?php echo $Roles['roles']['id'] ?>" hidden>
                                                <label for="nombre" class="form-label">Nombre del rol:</label>
                                                <input name="nombre" type="text" class="form-control" id="nombre" value="<?php  echo $Roles['roles']['nombre'] ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="descripcion" class="form-label">Descripcion:</label>
                                                <input name="descripcion" type="text" class="form-control" id="descripcion" value="<?php  echo $Roles['roles']['descripcion'] ?>" required>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado:</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" <?php echo    $Roles['roles']['estado'] === '0' ? 'selected' : ''; ?>>Seleccionar</option>
                                                    <option value="1" <?php echo    $Roles['roles']['estado'] === '1' ? 'selected' : ''; ?>>Activo</option>
                                                    <option value="2" <?php echo    $Roles['roles']['estado'] === '2' ? 'selected' : ''; ?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Actualizar rol</button>
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