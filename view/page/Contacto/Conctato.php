<?php require_once "view/include/header_page.php" ?>
<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="assets/img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Contacto</h2>
                <ol class="breadcrumb">
                    <li><a href="index.php">Inicio</a></li>
                    <li class="active">Contacto</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->
<!-- start contact section -->
<section id="aa-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-contact-area">
                    <div class="aa-contact-top">
                        <h2>Estamos para ayudarte</h2>
                        <p>
                            ¿Tienes preguntas, comentarios o sugerencias? Estamos aquí para ayudarte. Por favor, completa el siguiente formulario y nos pondremos en contacto contigo lo antes posible. Tu opinión es valiosa para nosotros y agradecemos la oportunidad de servirte.
                        </p>

                    </div>
                    <!-- contact map -->
                    <div class="aa-contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.706932400269!2d-86.27328044046827!3d12.132193382678096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f7155e408475d7d%3A0xb4f7ed9c2b79bc34!2sIES%20UNI%20-%20Oficinas%20de%20Coordinaci%C3%B3n!5e0!3m2!1ses!2sni!4v1700775634600!5m2!1ses!2sni" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <!-- Contact address -->
                    <div class="aa-contact-address">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="aa-contact-address-left">
                                    <form class="comments-form contact-form" action="index.php?c=page&a=EnviarCorreo" method="post" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="nombre" placeholder="Tu nombre" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="email" name="correo" placeholder="Correo electronico" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="asunto" placeholder="Asunto" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="empresa" placeholder="Empresa" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <textarea class="form-control " name="mensaje" cols="12" rows="12" placeholder="Mensage"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="aa-secondary-btn">Enviar</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="aa-contact-address-right">
                                    <address>
                                        <h4>$EBRA$</h4>
                                        <p>
                                            Somos más que una tienda; somos tu destino para descubrir el estilo que te define. En $EBRA $, fusionamos la moda con la individualidad, ofreciéndote una selección cuidadosamente curada de prendas que reflejan las últimas tendencias y tu singularidad.

                                        </p>
                                        <p><span class="fa fa-home"></span>Managua,Frente al estadio Soberania, NIC</p>
                                        <p><span class="fa fa-phone"></span>+505 5784-4921</p>
                                        <p><span class="fa fa-envelope"></span>Correo: support@$ebra$.com</p>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Subscribe section -->
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
<?php require_once "view/include/footer_page.php" ?>