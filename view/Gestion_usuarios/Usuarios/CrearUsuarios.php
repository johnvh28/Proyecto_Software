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
                        <li class="breadcrumb-item active">Crear Usuarios</li>
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
                            <h3 class="card-title">Crear Usuario</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=usuario&a=GuardarUsuario" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Rol:</label>
                                                <select name="rol" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <?php foreach ( $Roles['roles'] as $rol) : ?>
                                                        <option value="<?php echo $rol['id'] ?>"><?php echo  $rol['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="descripcion" class="form-label">Empleado:</label>
                                                <select name="id_empleado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <?php foreach ( $Empleado['empleados'] as $colaborador) : ?>
                                                        <option value="<?php echo $colaborador['id'] ?>"><?php echo "Codigo Empleado: " . $colaborador['cod_trabajador'] .  " Nombre: " . $colaborador['nombre'] . " " . $colaborador['apellido'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado:</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" >Seleccionar</option>
                                                    <option value="2" >Verificar</option>
                                                    <option value="3" >Inactivo</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Crear Usuario</button>
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