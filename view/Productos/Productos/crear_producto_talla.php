<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalle producto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Productos</a></li>
                        <li class="breadcrumb-item"><a href="#">detalle producto</a></li>
                        <li class="breadcrumb-item active">Crear producto talla</li>
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
                            <h3 class="card-title">Crear Detalle de producto</h3>
                        </div>
                        <div class="container">
                            <form id="crear" name="crear" method="POST" action="index.php?c=productos&a=GuardarPTalla" enctype="multipart/form-data" autocomplete="off">
                                <div class="card-body">
                                    <div class="row">
                             

                                    <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Producto</label>
                                                <select name="" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%" disabled>
                                                    <option>Seleccionar</option>
                                                    <?php foreach  ( $productos["producto"]  as $producto) : ?>
                                                        <option value="<?php echo $producto['id']; ?>"  <?php echo  $producto['id'] === $_GET['id'] ? 'selected' : ''; ?> ><?php echo $producto['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <input type="text" name="producto" value="<?php echo $_GET['id']?>" hidden>
                                    </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Talla</label>
                                                <select name="talla" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                    <option>Seleccionar</option>
                                                    <?php foreach ($prodTalla["prodtalla"]  as $Talla) : ?>
                                                        <option value="<?php echo $Talla['id']; ?>"><?php echo $Talla['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font: bold 16px Arial, sans-serif; color:black;">Foto</label>
                                                <input name="foto" type="file" class="form-control" id="foto" value="">
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
                                        <button type="submit" class="btn btn-success">Crear</button>
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