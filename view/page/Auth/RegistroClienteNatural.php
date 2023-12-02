<?php require_once "view/include/header_page.php" ?>
<style>
    .step-container {
        display: flex;
        justify-content: space-between;
        /* Cambiado de space-around a space-between */
        align-items: center;
        width: 100%;
    }

    .step {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid #007bff;
        background-color: white;
        color: #007bff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        font-weight: bold;
    }

    .step.active {
        background-color: #007bff;
        color: white;
    }
</style>
<div class="container-fluid">
    <form id="crear" name="crear" method="POST" action="index.php?c=page&a=GuardarCliente" enctype="multipart/form-data" autocomplete="off">
        <div class="row">
            <div class="d-flex justify-content-center mt-3">
                <div class="step-container">
                    <span class="step">1</span>
                    <span class="step">2</span>
                    <span class="step">3</span>
                </div>
            </div>
            <!-- Paso 1: Información personal -->
            <div class="tab" id="paso1">

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Nombre</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" value="" required>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Apellido</label>
                        <input name="apellido" type="text" class="form-control" id="descripcion" value="" required>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Tipo de identificacion:</label>
                        <select name="tipo_identificacion" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                            <option>Seleccionar</option>
                            <option VALUE="Cedula">Cedula</option>
                            <option VALUE="Pasaporte">Pasaporte</option>
                            <option VALUE="Cedula de residencia">Cedula de residencia</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Identificacion</label>
                        <input name="identificacion" type="text" class="form-control" id="identificacion" onblur="ValidarIdentificacion()" value="" required>
                    </div>
                </div>

            </div>

            <!-- Paso 2: Información de contacto -->
            <div class="tab" id="paso2" style="display: none;">

                <div class="form-group">
                    <div class="col-md-4 col-sm-12">

                        <label style="font: bold 16px Arial, sans-serif; color:black;">Telefono | Celular</label>
                        <input name="telefono" type="number" class="form-control" id="telefono" onblur="ValidarTelefono()" value="">

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 col-sm-12">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Fecha de nacimiento</label>
                        <input name="fecha_nacimiento" type="date" class="form-control" id="fecha_nacimiento" onblur="ValidarFecha()" value="" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 col-sm-12">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Genero</label>
                        <select name="genero" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                            <option>Seleccionar</option>
                            <?php foreach ($Genero['Generos'] as $Generos) : ?>
                                <option value="<?php echo $Generos['id']; ?>"><?php echo $Generos['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-12">
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

                <div class="form-group">
                    <div class="col-md-6 col-sm-12">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Nacionalidad</label>
                        <select name="nacionalidad" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                            <option>Seleccionar</option>
                            <?php foreach ($Pais['paises'] as $country) : ?>
                                <option value="<?php echo $country['id']; ?>"><?php echo $country['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-sm-12">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Direccion</label>
                        <textarea name="direccion" class=" form-control" id="" cols="50" rows="5"></textarea>
                    </div>
                </div>


            </div>

            <!-- Paso 3: Información adicional -->
            <div class="tab" id="paso3" style="display: none;">

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Correo</label>
                        <input name="correo" type="email" class="form-control" id="correo" onblur="ValidarCorreo()" value="">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Contraseña</label>
                        <input name="contraseña" type="text" class="form-control" id="contraseña" onblur="ValidarContraseña()" value="">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label style="font: bold 16px Arial, sans-serif; color:black;">Foto</label>
                        <input name="foto" type="file" class="form-control" id="foto" value="">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="cambiarPaso(-1)">Anterior</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="cambiarPaso(1)">Siguiente</button>
                <button type="submit" class="btn btn-success d-none" id="submitBtn">Registrar colaborador</button>
            </div>

        </div>
    </form>
</div>

<script>
    var totalSteps = 3; // Total de pasos en tu formulario
    var currentStep = 0;
    mostrarPaso(currentStep);

    function cambiarPaso(n) {
        currentStep = currentStep + n;
        mostrarPaso(currentStep);
    }

    function mostrarPaso(n) {
        var tabs = document.getElementsByClassName("tab");
        var steps = document.getElementsByClassName("step");

        for (var i = 0; i < tabs.length; i++) {
            tabs[i].style.display = "none";
        }

        tabs[n].style.display = "block";

        for (var i = 0; i < steps.length; i++) {
            steps[i].className = steps[i].className.replace(" active", "");
        }

        steps[n].className += " active";

        var prevBtn = document.getElementById("prevBtn");
        var nextBtn = document.getElementById("nextBtn");
        var submitBtn = document.getElementById("submitBtn");

        if (n === 0) {
            prevBtn.style.display = "none";
        } else {
            prevBtn.style.display = "inline";
        }

        if (n === (totalSteps - 1)) {
            nextBtn.style.display = "none";
            submitBtn.style.display = "inline";
        } else {
            nextBtn.style.display = "inline";
            submitBtn.style.display = "none";
        }
    }
</script>

<?php require_once "view/include/footer_Page.php" ?>