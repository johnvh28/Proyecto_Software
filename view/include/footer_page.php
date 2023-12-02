 <!-- footer -->
 <footer id="aa-footer">
    <!-- footer bottom -->
    <div class="aa-footer-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-footer-top-area">
              <div class="row">
                <div class="col-md-3 col-sm-6">
                  <div class="aa-footer-widget">
                    <h3>Menu</h3>
                    <ul class="aa-footer-nav">
                      <li><a href="#">Inicio</a></li>
                      <li><a href="#">Nuestro Productos</a></li>
                      <li><a href="#">Sobre Nosotros</a></li>
                      <li><a href="#">Contacto</a></li>
                     
                    </ul>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="aa-footer-widget">
                    <div class="aa-footer-widget">
                      <h3>Servicios</h3>
                      <ul class="aa-footer-nav">
                        <li><a href="#">Delivery</a></li>
                        <li><a href="#">Devoluciones</a></li>
                        <li><a href="#">Ofertas</a></li>
                        <li><a href="#">Descuento</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="aa-footer-widget">
                    <div class="aa-footer-widget">
                      <h3>Enlaces</h3>
                      <ul class="aa-footer-nav">
                        <li><a href="#">Ubicacion</a></li>
                        <li><a href="#">Busquedas</a></li>
                        <li><a href="#">Busquedas avanzadas</a></li>
                        <li><a href="#">Proveedores</a></li>
                        <li><a href="#">Preguntas mas frecuentes</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="aa-footer-widget">
                    <div class="aa-footer-widget">
                      <h3>Contactos</h3>
                      <address>
                        <p>Managua, Nicaragua</p>
                        <p><span class="fa fa-phone"></span>+505 5784-4921</p>
                        <p><span class="fa fa-envelope"></span>VogueNook@gmail.com</p>
                      </address>
                      <div class="aa-footer-social">
                        <a href="#"><span class="fa fa-facebook"></span></a>
                        <a href="#"><span class="fa fa-twitter"></span></a>
                        <a href="#"><span class="fa fa-google-plus"></span></a>
                        <a href="#"><span class="fa fa-youtube"></span></a>
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
    <!-- footer-bottom -->
    <div class="aa-footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-footer-bottom-area">
              <p>Deseño <a href="">Roberto</a></p>
              <div class="aa-footer-payment">
                <span class="fa fa-cc-mastercard"></span>
                <span class="fa fa-cc-visa"></span>
                <span class="fa fa-paypal"></span>
                <span class="fa fa-cc-discover"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- / footer -->

<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Inicio de sesión</h4>
                <form class="aa-login-form" action="index.php?c=login&a=ValidarLogin" method="post">
                    <label for="">Correo<span>*</span></label>
                    <input type="text" placeholder="ejemplo@gmail.com" name="usuario" required>
                    <label for="">Contraseña<span>*</span></label>
                    <input type="password" placeholder="Contraseña" name="contraseña" required>
                    <button class="aa-browse-btn" type="submit">Iniciar sesión</button>
                    <label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme"> Recuérdame</label>
                    <p class="aa-lost-password"><a href="#">¿Has olvidado tu contraseña?</a></p>
                    <div class="aa-register-now">
                        ¿Aún no tienes una cuenta?<a href="index.php?c=page&a=registro">¡Regístrate hoy!</a>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>  
  <!-- SmartMenus jQuery plugin -->
  <script type="text/javascript" src="assets/js/jquery.smartmenus.js"></script>
  <!-- SmartMenus jQuery Bootstrap Addon -->
  <script type="text/javascript" src="assets/js/jquery.smartmenus.bootstrap.js"></script>  
  <!-- To Slider JS -->
  <script src="assets/js/sequence.js"></script>
  <script src="assets/js/sequence-theme.modern-slide-in.js"></script>  
  <!-- Product view slider -->
  <script type="text/javascript" src="assets/js/jquery.simpleGallery.js"></script>
  <script type="text/javascript" src="assets/js/jquery.simpleLens.js"></script>
  <!-- slick slider -->
  <script type="text/javascript" src="assets/js/slick.js"></script>
  <!-- Price picker slider -->
  <script type="text/javascript" src="assets/js/nouislider.js"></script>
  <!-- Custom js -->
  <script src="assets/js/custom.js"></script> 
  
  <script src="assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="assets/admin/plugins/select2/js/select2.full.min.js"></script>
  <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
 
</script>
</body>

</html>