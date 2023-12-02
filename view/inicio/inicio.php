<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inicio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href>Inicio</a></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">


            <h5 class="mb-2"></h5>
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">
                    <!-- Widget: user widget style 1 -->
                    <div class="card card-widget widget-user shadow">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] ?></h3>
                            <h5 class="widget-user-desc">Codigo de empleado : <?php echo $_SESSION['codigo'] ?></h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="assets/img/fotos_perfil/<?php echo $_SESSION['foto'] ?>" alt="User Avatar" width="40" height="50">
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header"></h5>
                                        <span class="description-text">Fecha del
                                            dia</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>

                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header"></h5>
                                        <span class="description-text">Hora</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Cambiar
                                            contraseña</h5>
                                        <span class="description-text"><a href="#modal-default" data-toggle="modal" class="fas fa-pencil-alt"></a></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>

                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        <div id="modal-default" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="index.php?c=page&a=cambiocontraseña" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Contraseña</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="<?php echo $IdUsuario ?>" name="id" hidden>
                            <div class="form-group">
                                <label>Contraseña actual: </label>
                                <input type="text" name="contraseña_actual" class="form-control" id="contraseña_actual" onblur="ValidarClave()" required>
                            </div>
                            <div class="form-group">
                                <label>Nueva contraseña: </label>
                                <input type="text" name="contraseña_nueva" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirmar contraseña nueva: </label>
                                <input type="text" name="confirmacion" class="form-control" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn
                                btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn
                                btn-success" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</div>
<script>
    function ValidarClave() {
        var buscar = document.getElementById('contraseña_actual').value;
        var parametros = {
            "mi_busqueda": buscar,
            "accion": "8"
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
                    $('#contraseña_actual').val('');

                    return false;
                }
            }
        });
    }
</script>
<script src="jquery-3.4.1.min.js"></script>
<?php require_once "view/include/footer_admin.php" ?>
<style>
    .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }

    .colored-toast.swal2-icon-warning {
        background-color: #f8bb86 !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener referencias a los campos de contraseña
        var passwordInput = document.getElementsByName('contraseña_nueva')[0];
        var confirmInput = document.getElementsByName('confirmacion')[0];

        // Agregar evento de entrada para validar mientras el usuario escribe
        passwordInput.addEventListener('input', validarContraseña);
        confirmInput.addEventListener('input', validarContraseña);

        function validarContraseña() {
            // Obtener los valores de los campos de contraseña
            var passwordValue = passwordInput.value;
            var confirmValue = confirmInput.value;

            // Verificar si tienen al menos 8 caracteres
            var longitudValida = passwordValue.length >= 8;

            // Verificar si son iguales
            var coinciden = passwordValue === confirmValue;

            // Mostrar mensajes de error si es necesario
            if (!longitudValida) {
                passwordInput.setCustomValidity('La contraseña debe tener al menos 8 caracteres.');
                mostrarNotificacion('error', 'La contraseña debe tener al menos 8 caracteres.');
            } else {
                passwordInput.setCustomValidity('');
            }

            if (!coinciden) {
                confirmInput.setCustomValidity('Las contraseñas no coinciden.');
                mostrarNotificacion('error', 'Las contraseñas no coinciden.');
            } else {
                confirmInput.setCustomValidity('');
                mostrarNotificacion('success', 'Las contraseñas coinciden.');
            }
        }

        function mostrarNotificacion(icono, mensaje) {
            Swal.fire({
                icon: icono,
                title: mensaje,
                position: 'top-right',
                toast: true,
                showConfirmButton: true,
                timer: 3000
            });
        }
    });
</script>