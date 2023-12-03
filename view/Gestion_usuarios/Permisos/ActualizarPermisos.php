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
                        <li class="breadcrumb-item"><a href="#">Permisos de roles</a></li>
                        <li class="breadcrumb-item active">Asignar Permisos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php
    // Función para obtener la cantidad de submódulos en un módulo
    function obtenerCantidadSubmodulos($modulo)
    {
        return count($modulo['permisos']);
    }

    // Ordenar los módulos por la cantidad de submódulos de menor a mayor
    usort($data["modulos"], function ($a, $b) {
        return obtenerCantidadSubmodulos($a) - obtenerCantidadSubmodulos($b);
    });
    ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Asignación de permisos</h3>
                        </div>
                        <div class="card-body">
                            <form id="crear" name="crear" method="POST" action="index.php?c=usuario&a=GuardarPermiso" autocomplete="off">

                                <div class="form-group row">
                                    <div class="col-md-4">

                                        <label for="nombre" class="form-label">Rol:</label>
                                        <select name="" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%" disabled>
                                            <?php foreach ($Roles['roles'] as $rol) : ?>
                                                <option value="<?php echo $rol['id'] ?>" <?php echo  $rol['id'] === $_GET['id'] ? 'selected' : ''; ?>><?php echo  $rol['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="text" name="rol" value="<?php echo $_GET['id'] ?>" hidden>
                                        <input type="text" name="autorizado" value="<?php echo $_SESSION['IdUsuario'] ?>" hidden>
                                    </div>

                                    <div class="col-md-4 col-sm-12 d-flex align-items-end">

                                        <button type="submit" class="btn btn-primary">Asignar privilegios</button>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label style="font: bold 16px Arial, sans-serif; color:black;" for="categoria">Módulos y Permisos:</label>
                                            <div class="row">
                                                <?php foreach ($data["modulos"] as $modulo) : ?>
                                                    <div class="col-md-4">
                                                        <h5><?= $modulo['nombre'] ?></h5>
                                                        <?php foreach ($modulo['permisos'] as $submodulo) : ?>
                                                            <div style="margin-left: 20px; margin-bottom: 10px;">
                                                                <input type="checkbox" name="submodulos[<?= $modulo['id'] ?>][]" value="<?= $submodulo['id'] ?>" class="flat">
                                                                <span> <?= $submodulo['nombre'] ?> </span>
                                                            </div>


                                                        <?php endforeach; ?>
                                                        <button type="button" id="botonSeleccion_<?= $modulo['id'] ?>" class="btn btn-success" onclick="toggleSeleccionModulo('<?= $modulo['id'] ?>')">Seleccionar Todo</button>

                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

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
<script>
    var todosSeleccionados = false;

    function toggleSeleccionModulo(moduloId) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][name="submodulos[' + moduloId + '][]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = !todosSeleccionados;
        });
        todosSeleccionados = !todosSeleccionados; // Invertimos el estado general de todos seleccionados
        actualizarBoton(moduloId);
    }

    function actualizarBoton(moduloId) {
        var boton = document.getElementById('botonSeleccion_' + moduloId);
        var todosSeleccionadosEnModulo = todosLosCheckboxesSeleccionadosEnModulo(moduloId);

        if (todosSeleccionadosEnModulo) {
            boton.textContent = 'Deseleccionar Todo';
            boton.classList.remove('btn-success');
            boton.classList.add('btn-danger');
        } else {
            boton.textContent = 'Seleccionar Todo';
            boton.classList.remove('btn-danger');
            boton.classList.add('btn-success');
        }
    }

    function todosLosCheckboxesSeleccionadosEnModulo(moduloId) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][name="submodulos[' + moduloId + '][]"]');
        return Array.from(checkboxes).every(function(checkbox) {
            return checkbox.checked;
        });
    }
</script>

<?php require_once "view/include/footer_admin.php"; ?>