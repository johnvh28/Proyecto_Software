<?php require_once "view/include/header_page.php"; ?>
<!-- Cart view section -->
<section id="checkout">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="checkout-area">
                    <form action="index.php?c=page&a=pedido" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkout-left">
                                    <div class="panel-group" id="accordion">


                                        <!-- Billing Details -->
                                        <div class="panel panel-default aa-checkout-billaddress">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                        Detalles de pedidos
                                                    </a>
                                                </h4>
                                            </div>

                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <!-- Default checked radio -->
                                                        <div class="form-check h-100 border rounded-3">
                                                            <div class="p-3">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="Entrega Domicilio" />
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Entrega a domicilio
                                                                    <br />
                                                                    <small class="text-muted">5-7 dias para la entrega</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <!-- Default radio -->
                                                        <div class="form-check h-100 border rounded-3">
                                                            <div class="p-3">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="Entrega local" />
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    Entrega en tienda $EBRA$<br />
                                                                    <small class="text-muted">Entrega inmedianta</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="mostrar" style="display: none;">
                                                    <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <?php if ($Municipios['Municipios']) : ?>
                                                                <select name="municipio" id="municipio" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%">
                                                                    <?php foreach ($Municipios['Municipios'] as $departamento => $municipios) : ?>
                                                                        <optgroup label="<?= $departamento ?>">
                                                                            <?php foreach ($municipios as $municipio) : ?>
                                                                                <option value="<?= $municipio['id'] ?>" <?php echo  $municipio['id'] === $direccion['direccion']['cod_municipio'] ? 'selected' : ''; ?>><?= $municipio['nombre'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </optgroup>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php else : ?>
                                                                <p>No se encontraron resultados</p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <input type="text" placeholder="Apartamento." name="punto" value="<?php echo $direccion['direccion']['nombre'] ?>">
                                                        </div>
                                                    </div>





                                                    <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <textarea cols="8" rows="3" name="direccion" style="color:black;"><?php echo $direccion['direccion']['descripcion'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-right">
                                    <h4>Detalle del pedidos</h4>
                                    <div class="aa-order-summary-area">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Accion</th>
                                                    <th>Foto</th>
                                                    <th>Producto</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Precio Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($_SESSION['carrito'] as $producto) : ?>
                                                    <tr>
                                                        <td><a class="remove" href="index.php?c=page&a=eliminarProductoCarritos&id=<?php echo $producto['id']; ?>">
                                                                <fa class="fa fa-close"></fa>
                                                            </a></td>
                                                        <td><a href="#"><img src="assets/img/productos/<?php echo $producto['foto']; ?>" alt="img" width=50></a></td>
                                                        <td><strong><?php echo $producto['nombre']; ?> x <?php echo $producto['cantidad']; ?></strong></td>
                                                        <td>C$ <?php echo $producto['precio']; ?></td>
                                                        <td>C$ <?php echo $producto['cantidad'] * $producto['precio']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>

                                                    <th>total</th>
                                                    <td><?php echo calcularTotalCarrito($_SESSION['carrito']); ?></td>
                                                </tr>

                                            </tfoot>
                                        </table>
                                    </div>
                                    <h4>Metododos de pago:</h4>
                                    <div class="aa-payment-method">
                                        <label for="cashdelivery"><input type="radio" id="cashdelivery" name="optionsRadios" checked> Pago en entrega </label>
                                        <label for="paypal"><input type="radio" id="paypal" name="optionsRadios"> Via Paypal </label>
                                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">
                                        <input type="submit" value="Realizar pedido" class="aa-browse-btn">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once "view/include/footer_page.php"; ?>
<script>
    const radioButtons = document.getElementsByName('flexRadioDefault');
    const divMostrar = document.getElementById('mostrar');

    radioButtons.forEach(radioButton => {
        radioButton.addEventListener('change', () => {
            if (radioButton.id === 'flexRadioDefault1' && radioButton.checked) {
                divMostrar.style.display = 'block';
            } else {
                divMostrar.style.display = 'none';
            }
        });
    });
</script>