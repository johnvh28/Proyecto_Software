<?php require_once "view/include/header_page.php" ?>

<!-- Cart view section -->
<section id="cart-view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-view-area">
                    <div class="cart-view-table">
                        <form action="">
                            <?php if (!empty($_SESSION['carrito'])) : ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Accion</th>
                                                <th>Foto</th>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($_SESSION['carrito'] as $producto) : ?>
                                                <tr>
                                                    <td><a class="remove" href="index.php?c=page&a=eliminarProductoCarritos&id=<?php echo $producto['id']; ?>">
                                                            <fa class="fa fa-close"></fa>
                                                        </a></td>
                                                    <td><a href="#"><img src="assets/img/productos/<?php echo $producto['foto']; ?>" alt="img"></a></td>
                                                    <td><a class="aa-cart-title" href="#"><?php echo $producto['nombre']; ?></a></td>
                                                    <td><?php echo $producto['precio'] ?></td>
                                                    <td><input class="aa-cart-quantity" type="number" value="<?php echo $producto['cantidad']; ?>" min=1></td>
                                                    <td><?php echo $producto['cantidad'] * $producto['precio']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            <?php endif;
                           
                            ?>
                        </form>
                        <!-- Cart Total view -->
                        <div class="cart-view-total">
                            <h4>Total de carrito</h4>
                            <table class="aa-totals-table">
                                <tbody>
                                    <tr>
                                        <th>Total</th>
                                        <td><?php echo calcularTotalCarrito($_SESSION['carrito']); ?></td>
                                    </tr>

                                </tbody>
                            </table>
                            <a href="#" class="aa-cart-view-btn">Proceder a checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Cart view section -->

<?php require_once "view/include/footer_page.php" ?>