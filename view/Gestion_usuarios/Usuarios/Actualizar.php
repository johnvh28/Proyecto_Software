<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                        <li class="breadcrumb-item active">Actualizar Usuarios</li>
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
                            <h3 class="card-title">Actualizar Usuario</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=usuario&a=ActualizarUsuario" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="text"  name="id" value="<?php echo $usuario['usuario']['id']; ?>" hidden>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Rol:</label>
                                                <select name="rol" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <?php foreach ($Roles['roles'] as $rol) : ?>
                                                        <option value="<?php echo $rol['id'] ?>" <?php echo  $rol['id'] === $usuario['usuario']['id_rol'] ? 'selected' : ''; ?>><?php echo  $rol['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="" class="form-label">Codigo del trabajador</label>
                                                <input type="text" class="form-control" name="codigo" value="<?php echo $Empleado['empleado']['cod_trabajador']; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="descripcion" class="form-label">Empleado:</label>
                                                <input type="text" class="form-control" name="usuario" value="<?php echo $Empleado['empleado']['nombre'] . ' ' . $Empleado['empleado']['apellido']; ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado:</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="1" <?php echo  1 === $usuario['usuario']['estado'] ? 'selected' : ''; ?>>Activar</option>
                                                    <option value="2" <?php echo  2 === $usuario['usuario']['estado'] ? 'selected' : ''; ?>>Verificar</option>
                                                    <option value="3" <?php echo  3 === $usuario['usuario']['estado'] ? 'selected' : ''; ?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Actualizar Usuario</button>
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