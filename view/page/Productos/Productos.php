<?php

require_once "view/include/header_page.php"; ?>

<section id="aa-catg-head-banner">

    <div class="aa-catg-head-banner-area">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Productos</h2>
                <ol class="breadcrumb">
                    <li><a href="index.php?c=page">Inicio</a></li>
                    <li class="active">Productos</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->

<!-- product category -->
<section id="aa-product-category">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                <div class="aa-product-catg-content">
                    <div class="aa-product-catg-head">
                        <div class="aa-product-catg-head-left">
                            <form action="" class="aa-sort-form">
                                <label for="">Filtrar por</label>
                                <select name="">
                                    <option value="1" selected="Default">Defecto</option>
                                    <option value="2">Nombre</option>
                                    <option value="3">Precio</option>
                                    <option value="4">Fecha</option>
                                </select>
                            </form>
                            <form action="" class="aa-show-form">
                                <label for="">Mostrar por</label>
                                <select name="">
                                    <option value="1" selected="12">12</option>
                                    <option value="2">24</option>
                                    <option value="3">36</option>
                                </select>
                            </form>
                        </div>
                        <div class="aa-product-catg-head-right">
                            <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                            <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
                        </div>
                    </div>
                    <div class="aa-product-catg-body">
                        <ul class="aa-product-catg">
                            <?php
                            $productos = $productos['camisas'];

                            // Número de elementos por página
                            $elementosPorPagina = 10;

                            // Número total de páginas
                            $totalPaginas = ceil(count($productos) / $elementosPorPagina);

                            // Página actual, predeterminada a la primera página si no se establece
                            $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                            // Validar la página actual
                            if (!is_numeric($paginaActual) || $paginaActual < 1 || $paginaActual > $totalPaginas) {
                                $paginaActual = 1;
                            }

                            // Obtener la porción de datos para la página actual
                            $inicio = ($paginaActual - 1) * $elementosPorPagina;
                            $historialPaginado = array_slice($productos, $inicio, $elementosPorPagina);

                           

                            foreach ($historialPaginado as $producto) :
                            ?>
                                <li>
                                    <figure>
                                        <a class="aa-product-img" href="#"><img src="assets/img/productos/<?php echo $producto['foto'] ?>" alt="polo shirt img"></a>
                                        <a class="aa-add-card-btn" href="index.php?c=page&a=carritos&id=<?php echo $producto['id']; ?>">
                                            <span class="fa fa-shopping-cart"></span>Añadir al carro
                                        </a>

                                        <figcaption>
                                            <h4 class="aa-product-title"><a href="#"><?php echo $producto['nombre'] ?></a></h4>
                                            <span class="aa-product-price"><?php echo $producto['precio'] ?></span>
                                            <p class="aa-product-descrip"><?php echo $producto['descripcion'] ?></p>
                                        </figcaption>
                                    </figure>
                                    <div class="aa-product-hvr-content">
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                        <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                                    </div>
                                 
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="aa-product-catg-pagination">
                        <nav>



                            <ul class="pagination">


                                <?php if ($paginaActual > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?c=page&a=productos&pagina=<?php echo $paginaActual - 1; ?>" aria-label="Previo">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                </li>
                                <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                                    <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                                        <a href="index.php?c=page&a=productos&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($paginaActual < $totalPaginas) : ?>
                                    <li class="page-item">

                                        <a href="index.php?cpageo&a=productos&pagina=<?php echo $paginaActual + 1; ?>" aria-label="Siguiente">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
                <aside class="aa-sidebar">
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Mangas</h3>
                        <ul class="aa-catg-nav">
                            <?php foreach ($manga['manga'] as $modelos) : ?>
                                <li><a href="index.php?c=page&a=mangas&id=<?php echo $modelos['id'] ?>"><?php echo $modelos['nombre'] ?>s</a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Etiquetas</h3>
                        <div class="tag-cloud">
                            <?php foreach ($modelo['modelo'] as $modelo) : ?>
                                <a href="index.php?c=page&a=modelos&id=<?php echo $modelo['id'] ?>"><?php echo $modelo['nombre'] ?></a>
                            <?php endforeach; ?>

                        </div>
                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Precio</h3>
                        <!-- price range -->
                        <div class="aa-sidebar-price-range">
                            <form action="">
                                <input type="text">
                                <button class="aa-filter-btn" type="submit">Filter</button>
                            </form>
                        </div>

                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Colores</h3>
                        <div class="tag-cloud">
                            <?php foreach ($color['color'] as $color) : ?>
                                <a class="" href="index.php?c=page&a=colores&id=<?php echo $color['id'] ?>"><?php echo $color['nombre']; ?></a>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<!-- / product category -->



<?php require_once "view/include/footer_page.php"; ?>