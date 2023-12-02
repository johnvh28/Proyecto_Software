<?php
require_once "view/include/header_admin.php";
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Colaboradores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de negocio</a></li>
                        <li class="breadcrumb-item"><a href="#">Colaboradores</a></li>
                        <li class="breadcrumb-item active">Registrar Colaboraores</li>
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
                            <h3 class="card-title">Registrar colaboradores</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=GuardarColaborador" enctype="multipart/form-data" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Nombre</label>
                                                <input name="nombre" type="text" class="form-control" id="nombre" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Apellido</label>
                                                <input name="apellido" type="text" class="form-control" id="descripcion" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Tipo de identificacion</label>
                                                <input name="tipo_identificacion" type="text" class="form-control" id="" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Identificacion</label>
                                                <input name="identificacion" type="text" class="form-control" id="identificacion" onblur="ValidarIdentificacion()" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Telefono | Celular</label>
                                                <input name="telefono" type="number" class="form-control" id="telefono" onblur="ValidarTelefono()" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Correo</label>
                                                <input name="correo" type="email" class="form-control" id="correo"  onblur="ValidarCorreo()" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Fecha de nacimiento</label>
                                                <input name="fecha_nacimiento" type="date" class="form-control" id="fecha_nacimiento" onblur="ValidarFecha()" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Codigo Inss</label>
                                                <input name="codigo_inss" type="text" class="form-control" id="codigo_inss" onblur="ValidarInss()" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Foto</label>
                                                <input name="foto" type="file" class="form-control" id="foto" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Genero</label>
                                                <select name="genero" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option>Seleccionar</option>
                                                    <?php foreach ($Genero['Generos'] as $Generos) : ?>
                                                        <option value="<?php echo $Generos['id']; ?>"><?php echo $Generos['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Localidad</label>
                                                <?php if ($Municipios['Municipios']) : ?>
                                                    <select name="municipio" id="municipio" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                        <?php foreach ($Municipios['Municipios'] as $departamento => $municipios) : ?>
                                                            <optgroup label="<?= $departamento ?>">
                                                                <?php foreach ($municipios as $municipio) : ?>
                                                                    <option value="<?= $municipio['id'] ?>"><?= $municipio['nombre'] ?></option>
                                                                <?php endforeach; ?>
                                                            </optgroup>
                                                        <?php endforeach; ?>
                                                    </select>
                                                <?php else : ?>
                                                    <p>No se encontraron resultados</p>
                                                <?php endif; ?>

                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Estado civil</label>

                                                <select name="estadocivil" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option>Select</option>
                                                    <?php foreach ($EstadoCivil['EstadoCiviles'] as $EstadoCiviles) : ?>
                                                        <option value="<?php echo $EstadoCiviles['id']; ?>"><?php echo $EstadoCiviles['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Nacionalidad</label>

                                                <select name="nacionalidad" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option>Select</option>
                                                    <?php foreach ($Pais['paises'] as $country) : ?>
                                                        <option value="<?php echo $country['id']; ?>"><?php echo $country['nombre']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Estado</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option>Seleccionar</option>
                                                    <option VALUE=1>Activo</option>
                                                    <option VALUE=2>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Direccion</label>
                                                <textarea name="direccion" class=" form-control" id="" cols="50" rows="5"></textarea>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Registrar colaborador</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<script>
    function ValidarIdentificacion() {
        var buscar = document.getElementById('identificacion').value;
        var parametros = {
            "mi_busqueda": buscar,
            "accion": "3"
        };

        // Realizar la solicitud AJAX
        $.ajax({
            data: parametros,
            url: 'validar.php',
            type: 'POST',
            async: false, // Configurar la solicitud como sincrónica
            success: function(response) {
                if (response.success) {
                    // No hay errores en la clave
                    return true;
                } else {
                    // Mostrar los errores en una alerta
                    var errors = response.errors;
                    var errorMessage = "Errores:\n";
                    for (var i = 0; i < errors.length; i++) {
                        errorMessage += "- " + errors[i] + "\n";
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el formulario',
                        text: errorMessage
                    });
                    $('#identificacion').val('');

                    return false;
                }
            }
        });
    }
</script>
<script src="jquery-3.4.1.min.js"></script>

<script>
    function ValidarTelefono() {
        var buscar = document.getElementById('telefono').value;
        var parametros = {
            "mi_busqueda": buscar,
            "accion": "9"
        };

        // Realizar la solicitud AJAX
        $.ajax({
            data: parametros,
            url: 'validar.php',
            type: 'POST',
            async: false, // Configurar la solicitud como sincrónica
            success: function(response) {
                if (response.success) {
                    // No hay errores en la clave
                    return true;
                } else {
                    // Mostrar los errores en una alerta
                    var errors = response.errors;
                    var errorMessage = "Errores:\n";
                    for (var i = 0; i < errors.length; i++) {
                        errorMessage += "- " + errors[i] + "\n";
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el formulario',
                        text: errorMessage
                    });
                    $('#telefono').val('');

                    return false;
                }
            }
        });
    }
</script>
<script src="jquery-3.4.1.min.js"></script>

<script>
    function ValidarCorreo() {
        var buscar = document.getElementById('correo').value;
        var parametros = {
            "mi_busqueda": buscar,
            "accion": "10"
        };

        // Realizar la solicitud AJAX
        $.ajax({
            data: parametros,
            url: 'validar.php',
            type: 'POST',
            async: false, // Configurar la solicitud como sincrónica
            success: function(response) {
                if (response.success) {
                    // No hay errores en la clave
                    return true;
                } else {
                    // Mostrar los errores en una alerta
                    var errors = response.errors;
                    var errorMessage = "Errores:\n";
                    for (var i = 0; i < errors.length; i++) {
                        errorMessage += "- " + errors[i] + "\n";
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el formulario',
                        text: errorMessage
                    });
                    $('#correo').val('');

                    return false;
                }
            }
        });
    }
</script>
<script src="jquery-3.4.1.min.js"></script>

<script>
    function ValidarFecha() {
        var buscar = document.getElementById('fecha_nacimiento').value;
        var parametros = {
            "mi_busqueda": buscar,
            "accion": "4"
        };

        // Realizar la solicitud AJAX
        $.ajax({
            data: parametros,
            url: 'validar.php',
            type: 'POST',
            async: false, // Configurar la solicitud como sincrónica
            success: function(response) {
                if (response.success) {
                    // No hay errores en la clave
                    return true;
                } else {
                    // Mostrar los errores en una alerta
                    var errors = response.errors;
                    var errorMessage = "Errores:\n";
                    for (var i = 0; i < errors.length; i++) {
                        errorMessage += "- " + errors[i] + "\n";
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el formulario',
                        text: errorMessage
                    });
                    $('#fecha_nacimiento').val('');

                    return false;
                }
            }
        });
    }
</script>
<script src="jquery-3.4.1.min.js"></script>

<script>
    function ValidarInss() {
        var buscar = document.getElementById('codigo_inss').value;
        var parametros = {
            "mi_busqueda": buscar,
            "accion": "6"
        };

        // Realizar la solicitud AJAX
        $.ajax({
            data: parametros,
            url: 'validar.php',
            type: 'POST',
            async: false, // Configurar la solicitud como sincrónica
            success: function(response) {
                if (response.success) {
                    // No hay errores en la clave
                    return true;
                } else {
                    // Mostrar los errores en una alerta
                    var errors = response.errors;
                    var errorMessage = "Errores:\n";
                    for (var i = 0; i < errors.length; i++) {
                        errorMessage += "- " + errors[i] + "\n";
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el formulario',
                        text: errorMessage
                    });
                    $('#codigo_inss').val('');

                    return false;
                }
            }
        });
    }
</script>
<script src="jquery-3.4.1.min.js"></script>

<?php
require_once "view/include/footer_admin.php";
?>