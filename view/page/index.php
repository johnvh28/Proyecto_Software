<?php
require_once "view/include/header_page.php";
?>
<style>
  /* Estilos para pantallas más grandes */
  .seq-title {
    text-align: center;
    /* Alinear al centro para pantallas más grandes */
  }

  .coleccion-hombres {
    margin-top: -60px;
  }

  .botones {
    margin-top: 300px
  }

  /* Estilos para dispositivos móviles */
  @media only screen and (max-width: 767px) {
    .seq-title {
      text-align: left;
      /* Alinear a la izquierda en dispositivos móviles si es necesario */
    }

    .coleccion-hombres {
      margin-top: 0;
      /* Restablecer el margen en dispositivos móviles */
    }

    a.aa-shop-now-btn {
      display: block;
      /* Hacer que el enlace ocupe todo el ancho en dispositivos móviles */
      margin-top: 10px;
      /* Espaciado entre el h2 y el enlace en dispositivos móviles */
      text-align: center;
      /* Alinear al centro en dispositivos móviles */
    }
  }
</style>
<section id="aa-slider">
  <div class="aa-slider-area">
    <div id="sequence" class="seq">
      <div class="seq-screen">
        <ul class="seq-canvas">
          <li>

            <div class="seq-model">
              <img data-seq src="assets/img/slider/Slider_02.png" alt="Men slide img" />
            </div>
            <div class="seq-title">
              <h2 data-seq class="coleccion-hombres">Coleccion de hombres</h2>
              <a data-seq href="#" class="aa-shop-now-btn aa-secondary-btn  botones">Comprar ahora</a>
            </div>

          </li>
          <li>
            <div class="seq-model">
              <img data-seq src="assets/img/slider/Slider_02.png" alt="Wristwatch slide img" />
            </div>

            <div class="seq-title">
              <h2 data-seq class="coleccion-hombres">Coleccion de damas</h2>
              <a data-seq href="#" class=" aa-shop-now-btn aa-secondary-btn  botones">Comprar ahora</a>
            </div>

          </li>
        </ul>
      </div>
      <!-- slider navigation btn -->
      <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
        <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
        <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
      </fieldset>
    </div>
  </div>
</section>
<!----BANNER DE PROMOCIONES-->
<!-- Start Promo section -->
<section id="aa-promo">
  <article class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="aa-promo-area">
          <div class="row">
            <!-- promo right -->
            <div class="col-md-12">
              <div class="aa-promo-right">
                <div class="aa-single-promo-right">
                  <div class="aa-promo-banner">
                    <img src="assets/img/Banner_01.png" alt="img">
                    <div class="aa-prom-content">
                      <div class="seq-title">

                        <a data-seq href="#" style="margin-top:50px; padding-left:5%;" class="aa-shop-now-btn aa-secondary-btn">Comprar ahora</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="aa-single-promo-right">
                  <div class="aa-promo-banner">
                    <img src="assets/img/Banner_02.png" alt="img">
                    <div class="aa-prom-content">
                      <div class="seq-title">


                        <a data-seq href="#" style="margin-top:50px; padding-left:5%;" class="aa-shop-now-btn aa-secondary-btn">Comprar ahora</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="aa-single-promo-right">
                  <div class="aa-promo-banner">
                    <img src="assets/img/Banner_02.png" alt="img">
                    <div class="aa-prom-content">
                      <div class="seq-title">


                        <a data-seq href="#" style="margin-top:50px; padding-left:5%;" class="aa-shop-now-btn aa-secondary-btn">Comprar ahora</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="aa-single-promo-right">
                  <div class="aa-promo-banner">
                    <img src="assets/img/Banner_04.png" alt="img">
                    <div class="aa-prom-content">
                      <div class="seq-title">
                        <a data-seq href="#" style="margin-top:50px; padding-left:5%;" class="aa-shop-now-btn aa-secondary-btn">Comprar ahora</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>
</section>

<!---Buscando error---->
<section id="aa-product">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="aa-product-area">
            <div class="aa-product-inner">
              <!-- start prduct navigation -->
              <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#men" data-toggle="tab">Productos</a></li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Start men product category -->
                <div class="tab-pane fade in active" id="men">
                  <ul class="aa-product-catg">
                    <?php
                    $productosPorPagina = 10; // Puedes ajustar este valor según tus necesidades
                    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                    // Calcula el índice de inicio para la paginación
                    $indiceInicio = ($paginaActual - 1) * $productosPorPagina;

                    // Filtra los productos a mostrar en la página actual
                    $productosPagina = array_slice($productos['camisas'], $indiceInicio, $productosPorPagina);

                    foreach ($productos['camisas'] as $productos) : ?>
                      <li>
                        <figure>
                          <a class="aa-product-img" href="#"><img src="assets/img/productos/<?php echo $productos['foto'] ?>" alt="polo shirt img"></a>
                          <a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span>Agregar al carro</a>
                          <figcaption>
                            <h4 class="aa-product-title"><a href="#"><?php echo $productos['nombre'] ?></a></h4>
                            <span class="aa-product-price">C$ <?php echo $productos['precio'] ?></< /span>
                          </figcaption>
                        </figure>
                        <div class="aa-product-hvr-content">
                          <a href="#" data-toggle="tooltip" data-placement="top" title="Añadir a lista de deseo"><span class="fa fa-heart-o"></span></a>
                          <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                          <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                        </div>
                      </li>
                    <?php endforeach; ?>
                    
                    
                  </ul>
                  <a class="aa-browse-btn" href="index.php?c=page&a=productos">Todos los productos <span class="fa fa-long-arrow-right"></span></a>
                </div>

              </div>
              <!-- quick view modal -->
              <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <div class="row">
                        <!-- Modal view slider -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="aa-product-view-slider">
                            <div class="simpleLens-gallery-container" id="demo-1">
                              <div class="simpleLens-container">
                                <div class="simpleLens-big-image-container">
                                  <a class="simpleLens-lens-image" data-lens-image="assets/img/3.png">
                                    <img src="assets/img/3.png" class="simpleLens-big-image">
                                  </a>
                                </div>
                              </div>
                              <div class="simpleLens-thumbnails-container">
                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="assets/img/2.png" data-big-image="assets/img/2.png">
                                  <img src="assets/img/2.png" width="50" height="50">
                                </a>
                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="assets/img/1.png" data-big-image="assets/img/1.png">
                                  <img src="assets/img/1.png" width="50" height="50">
                                </a>

                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="assets/img/3.png" data-big-image="assets/img/3.png">
                                  <img src="assets/img/3.png" width="50" height="50">
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Modal view content -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="aa-product-view-content">
                            <h3>Camisas Polo</h3>
                            <div class="aa-price-block">
                              <span class="aa-product-view-price">$34.99</span>
                              <p class="aa-product-avilability">Disponible: <span>En
                                  stock</span></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                              Officiis animi, veritatis
                              quae repudiandae quod nulla porro quidem, itaque quis
                              quaerat!</p>
                            <h4>Size</h4>
                            <div class="aa-prod-view-size">
                              <a href="#">S</a>
                              <a href="#">M</a>
                              <a href="#">L</a>
                              <a href="#">XL</a>
                            </div>
                            <div class="aa-prod-quantity">
                              <form action="">
                                <select name="" id="">
                                  <option value="0" selected="1">1</option>
                                  <option value="1">2</option>
                                  <option value="2">3</option>
                                  <option value="3">4</option>
                                  <option value="4">5</option>
                                  <option value="5">6</option>
                                </select>
                              </form>
                              <p class="aa-prod-category">
                                Categoria: <a href="#">Camisa Polo</a>
                              </p>
                            </div>
                            <div class="aa-prod-view-bottom">
                              <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Añadir al
                                carro</a>
                              <a href="#" class="aa-add-to-cart-btn">Ver detalles</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- / quick view modal -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="aa-banner">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="aa-banner-area">
            <a href="#"><img src="assets/img/Banner_04.png" alt="fashion banner img"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- PROMOCIONES----->
<!-- Support section -->
<section id="aa-support">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="aa-support-area">
          <!-- single support -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="aa-support-single">
              <span class="fa fa-truck"></span>
              <h4>Delivery</h4>
              <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
            </div>
          </div>
          <!-- single support -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="aa-support-single">
              <span class="fa fa-clock-o"></span>
              <h4>Politicas de devoluciones</h4>
              <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
            </div>
          </div>
          <!-- single support -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="aa-support-single">
              <span class="fa fa-phone"></span>
              <h4>Soporte 24/7</h4>
              <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="aa-subscribe">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="aa-subscribe-area">
          <h3>Suscribte para nuestra noticias</h3>
          <p>Descubre las últimas novedades, tendencias y ofertas exclusivas directamente en tu bandeja de entrada. Entra a formar parte de nuestra comunidad y mantente informado sobre todo lo relacionado con la moda, estilo de vida y promociones especiales. ¡Tu conexión con la moda comienza aquí!</p>
          <form action="" class="aa-subscribe-form">
            <input type="email" name="" id="" placeholder="Introduce tu correo">
            <input type="submit" value="Suscribirse">
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
require_once "view/include/footer_page.php";
?>