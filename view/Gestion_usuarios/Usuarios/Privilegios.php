<?php require_once "view/include/header_admin.php" ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Roles temporales</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestion de usuarios</a></li>
                        <li class="breadcrumb-item active">Roles temporales</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <section class="row">
                <article class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="assets/img/fotos_Perfil/<?php echo $Empleado['empleado']["foto"] ?>" alt="<?php echo $HistorialSalario['historial']["nombre"] ?>">
                            </div>

                            <h3 class="profile-username text-center">
                                <?php echo $Empleado['empleado']["nombre"] . ' ' . $Empleado['empleado']["apellido"] ?>
                            </h3>

                            <p class="text-muted text-center">Colaborador</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Usuario:</span>
                                        <span class="font-weight-bold"><?php echo $Empleado['empleado']["usuario"] ?></span>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Rol:</span>
                                        <span class="font-weight-bold"><?php echo $Empleado['empleado']["rol"] ?></span>
                                    </div>
                                </li>
                            </ul>
                            <a href="index.php?c=usuario" class="btn btn-primary btn-block"><b>Volver Inicio</b></a>

                        </div>
                    </div>
                </article>
                <article class="col-md-8">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Roles Activos</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Linea de tiempo</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Agregar roles</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div class="container mt-5">
                                                <?php
                                                // Verifica si $historico está definido y si tiene una clave 'historico'
                                                if (isset($historico) && is_array($historico) && array_key_exists('historico', $historico)) {
                                                    // Obtén la información del historial
                                                    $historicos = $historico['historico'];

                                                    // Verifica si $historicos es un array antes de continuar
                                                    if (is_array($historicos)) {
                                                        // Ordena el historial por fecha de manera descendente
                                                        usort($historicos, function ($a, $b) {
                                                            return strtotime($b['fecha_registro']) - strtotime($a['fecha_registro']);
                                                        });

                                                        // Configuración de paginación
                                                        $registrosPorPagina = 10;
                                                        $totalRegistros = count($historicos);
                                                        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                                                        // Obtén el número de página actual
                                                        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                                                        // Calcula el índice de inicio y fin para la paginación
                                                        $indiceInicio = ($paginaActual - 1) * $registrosPorPagina;
                                                        $indiceFin = min($indiceInicio + $registrosPorPagina - 1, $totalRegistros - 1);

                                                        // Filtra los registros para la página actual
                                                        $historicoPaginado = array_slice($historicos, $indiceInicio, $registrosPorPagina);
                                                ?>

                                                        <!-- Ahora puedes mostrar tu tabla HTML con los resultados paginados -->
                                                        <table class="table table-bordered">
                                                            <!-- Encabezados de la tabla -->
                                                            <thead>
                                                                <tr>
                                                                    <th>Fecha</th>
                                                                    <th>Rol</th>
                                                                    <th>Autorizado</th>
                                                                    <th>Acción</th>
                                                                </tr>
                                                            </thead>
                                                            <!-- Cuerpo de la tabla -->
                                                            <tbody>
                                                                <?php foreach ($historicoPaginado as $historia) : ?>
                                                                    <tr>
                                                                        <td><?php echo $historia['fecha_registro'] ?></td>
                                                                        <td><?php echo $historia['rol'] ?></td>
                                                                        <td><?php echo $historia['autorizado'] ?></td>
                                                                        <td>
                                                                            <?php if ($historia['estado'] == 2) : ?>
                                                                                <a href="index.php?c=usuario&a=EliminarRoles&id=<?php echo $historia['id'] ?>&estado=1&usuario=<?php echo $historia['id_usuario'] ?>" class="btn btn-primary btn-sm">Activar</a>
                                                                            <?php else : ?>
                                                                                <a href="index.php?c=usuario&a=EliminarRoles&id=<?php echo $historia['id'] ?>&estado=2&usuario=<?php echo $historia['id_usuario'] ?>" class="btn btn-danger btn-sm">Desactivar Rol</a>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>

                                                        <!-- Paginación de Bootstrap -->
                                                        <nav aria-label="Page navigation">
                                                            <ul class="pagination">
                                                                <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                                                                    <li class="page-item <?php echo ($i == $paginaActual) ? 'active' : ''; ?>">
                                                                        <a class="page-link" href="index.php?c=usuario&a=PrivilegiosUsuario&id=1&pagina=<?php echo $i ?>"><?php echo $i ?></a>
                                                                    </li>
                                                                <?php endfor; ?>
                                                            </ul>
                                                        </nav>

                                                <?php } else {
                                                        // Manejar el caso en que $historicos no es un array
                                                        echo "No hay datos de historico disponibles.";
                                                    }
                                                } else {
                                                    // Manejar el caso en que $historico no está definido o no tiene la clave 'historico'
                                                    echo "No hay datos de historico disponibles.";
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="timeline">

                                            <div class="timeline timeline-inverse">
                                                <?php foreach ($historico['historico'] as $historias) : ?>
                                                    <div class="time-label">
                                                        <span class="bg-danger">
                                                            <?php echo $historias['fecha_registro'] ?>
                                                        </span>
                                                    </div>
                                                    <!-- /.timeline-label -->
                                                    <!-- timeline item -->
                                                    <div>
                                                        <i class="fas fa-envelope bg-primary"></i>

                                                        <div class="timeline-item">
                                                            <h3 class="timeline-header">Rol: <?php echo $historias['rol'] ?> </h3>

                                                            <div class="timeline-body">
                                                                <p>
                                                                    Autorizado por: <?php echo $historias['autorizado'] ?>
                                                                </p>
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <?php if ($historias['estado'] == 2) : ?>
                                                                    <a href="index.php?c=usuario&a=EliminarRoles&id=<?php echo $historias['id'] ?>&estado=1&usuario=<?php echo $historias['id_usuario'] ?>" class="btn btn-primary btn-sm">Activar</a>
                                                                <?php else : ?>
                                                                    <a href="index.php?c=usuario&a=EliminarRoles&id=<?php echo $historias['id'] ?>&estado=2&usuario=<?php echo $historias['id_usuario'] ?>" class="btn btn-danger btn-sm">Desactivar Rol</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>


                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->

                                        <div class="tab-pane" id="settings">
                                            <form class="form-horizontal" method="post" action="index.php?c=usuario&a=InsertarPrivilegio">
                                                <div class="form-group row">
                                                    <label for="nombre" class="form-label">Rol:</label>
                                                    <select name="rol" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                        <?php foreach ($Roles['roles'] as $rol) : ?>
                                                            <option value="<?php echo $rol['id'] ?>"><?php echo  $rol['nombre'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <input type="text" name="autorizado" value="<?php echo $_SESSION['IdUsuario'] ?>" hidden>
                                                <input type="text" name="Id" value="<?php echo $_GET['id'] ?>" hidden>


                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">agregar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </article>
            </section>
        </div>
    </section>
</div>

<?php require_once "view/include/footer_admin.php" ?>