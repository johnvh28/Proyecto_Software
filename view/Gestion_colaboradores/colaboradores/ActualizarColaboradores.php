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
                        <li class="breadcrumb-item active">Actualizar Colaboraores</li>
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
                            <h3 class="card-title" Actualizarr colaboradores</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=negocio&a=ActualizarColaboradores" enctype="multipart/form-data" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="text" name="FotoVieja"  value="<?php echo $Colaboradores['empleado']['foto'] ?>"         hidden>
                                        <input type="text" name="id"         value="<?php echo $Colaboradores['empleado']['IdEmpleado'] ?>"         hidden>
                                        <input type="text" name="referencia" value="<?php echo $Colaboradores['empleado']['referencia'] ?>"                 hidden>
                                        <input type="text" name="persona"    value="<?php echo $Colaboradores['empleado']['IdPersona'] ?>"          hidden>
                                        <input type="text" name="personaNatural" value="<?php echo $Colaboradores['empleado']['personaNatural'] ?>" hidden>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Nombre</label>
                                                <input name="nombre" type="text" class="form-control" id="nombre" value="<?php echo  $Colaboradores['empleado']['NombrePersona']?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Apellido</label>
                                                <input name="apellido" type="text" class="form-control" id="descripcion" value="<?php echo  $Colaboradores['empleado']['apellido']?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Tipo de identificacion</label>
                                                <input name="tipo_identificacion" type="text" class="form-control" id="identificacion" value="<?php echo  $Colaboradores['empleado']['tipo_identificacion']?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Identificacion</label>
                                                <input name="identificacion" type="text" class="form-control" id="descripcion" value="<?php echo  $Colaboradores['empleado']['identificacion']?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Telefono | Celular</label>
                                                <input name="telefono" type="number" class="form-control" id="descripcion" value="<?php echo  $Colaboradores['empleado']['telefono']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Correo</label>
                                                <input name="correo" type="email" class="form-control" id="descripcion" value="<?php echo  $Colaboradores['empleado']['correo']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Fecha de nacimiento</label>
                                                <input name="fecha_nacimiento" type="date" class="form-control" id="descripcion" value="<?php echo  $Colaboradores['empleado']['fecha_nacimiento']?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Codigo Inss</label>
                                                <input name="codigo_inss" type="text" class="form-control" id="descripcion" value="<?php echo $Colaboradores['empleado']['codigo_inss'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Foto</label>
                                                <input name="foto" type="file" class="form-control" id="foto" value="<?php echo $Colaboradores['empleado'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Genero</label>
                                                <select name="genero" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option>Seleccionar</option>
                                                    <?php foreach ($Genero['Generos'] as $Generos) : ?>
                                                        <option value="<?php echo $Generos['id']; ?>"  <?php echo  $Generos['id'] === $Colaboradores['empleado']['sexo'] ? 'selected' : ''; ?>><?php echo $Generos['nombre']; ?></option>
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
                                                                    <option value="<?= $municipio['id'] ?>" <?php echo  $municipio['id'] === $Colaboradores['empleado']['municipios'] ? 'selected' : ''; ?> ><?= $municipio['nombre'] ?></option>
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
                                                        <option value="<?php echo $EstadoCiviles['id']; ?>" <?php echo  $EstadoCiviles['id'] === $Colaboradores['empleado']['IdEstado'] ? 'selected' : ''; ?>><?php echo $EstadoCiviles['nombre']; ?></option>
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
                                                        <option value="<?php echo $country['id']; ?>"  <?php echo  $country['id'] === $Colaboradores['empleado']['paises'] ? 'selected' : ''; ?>><?php echo $country['nombre']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Estado</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" <?php  echo $Colaboradores['empleado']['estado'] === '0' ? 'selected' : ''; ?>>Seleccionar</option>
                                                    <option VALUE=1 <?php  echo $Colaboradores['empleado']['estado'] === '1' ? 'selected' : ''; ?>>Activo</option>
                                                    <option VALUE=2 <?php echo $Colaboradores['empleado']['estado']==='2'? 'selected':'' ?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Direccion</label>
                                                <textarea name="direccion" class=" form-control" id="" cols="50" rows="5"><?php echo $Colaboradores['empleado']['punto'] ?></textarea>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Actualizar colaborador</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<?php
require_once "view/include/footer_admin.php";
?>