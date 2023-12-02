<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Divisa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Caja</a></li>
                        <li class="breadcrumb-item"><a href="#">Divisas</a></li>
                        <li class="breadcrumb-item active">Crear divisa</li>
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
                            <h3 class="card-title">Crear Divisa</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=caja&a=crear_moneda" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input name="nombre" type="text" class="form-control" id="nombre" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="descripcion" class="form-label">Simbolo</label>
                                                <input name="simbolo" type="text" class="form-control" id="descripcion" value="" required>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="local" class="form-label">Tipo de divisa</label>
                                                <select name="local" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" >Tipo de moneda</option>
                                                    <option value="1" >Moneda local</option>
                                                    <option value="2" >Moneda extrangera</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select name="estado" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option value="0" >Seleccionar</option>
                                                    <option value="1" >Activo</option>
                                                    <option value="2" >Inactivo</option>
                                                </select>
                                            </div>
                                        </div>                                 

                                    </div>
                                    <div class="btn-list">
                                        <button type="submit" class="btn btn-success">Registrar divisa</button>
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