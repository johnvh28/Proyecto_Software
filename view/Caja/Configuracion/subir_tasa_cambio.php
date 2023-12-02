<?php
require_once "view/include/header_admin.php";
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Subir tasa de cambio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Caja</a></li>
                        <li class="breadcrumb-item"><a href="#">Configuracion</a></li>
                        <li class="breadcrumb-item active">tasa de cambio</li>
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
                            <h3 class="card-title">Subir tasa de cambio</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=caja&a=subir_tipo_cambio" enctype="multipart/form-data" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Moneda</label>
                                                <select name="moneda" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option>Seleccionar</option>
                                                    <?php foreach ($divisa["moneda"] as $divisa) : ?>
                                                        <option value="<?php echo $divisa['id']; ?>"><?php echo $divisa['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Archivo</label>
                                                <input name="archivo_excel" type="file" class="form-control" id="foto" value="">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Registrar tasa de cambio</button>
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