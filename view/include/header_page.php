<?php
$lifetime = 60 * 60 * 8; // 8 horas en segundos
if (session_status() == PHP_SESSION_NONE) {
  session_set_cookie_params($lifetime);
  session_start();
  if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params($lifetime);
    session_start();

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $lifetime)) {
      // La duración de la cookie ha expirado, se cierra la sesión
      session_unset();
      session_destroy();

      // Redirecciona a la página de cierre de sesión
      header("Location: index.php?c=login&a=cerra_session&id=" . $_SESSION['IdUsuario']);
      exit();
    }

    // Actualiza la marca de tiempo de la última actividad
    $_SESSION['last_activity'] = time();
  }
}
if (isset($_SESSION['mensaje'])) {
  echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "' . $_SESSION['tipo'] . '",
                text: "' . $_SESSION['mensaje'] . '"
            });
        });
    </script>';
  unset($_SESSION['mensaje']);
  unset($_SESSION['tipo']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>$EBRA$ | Inicio</title>
  <link rel="icon" href="assets/img/Logos/logo.png" type="image/png">
  <!-- Font awesome -->
  <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="assets/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.simpleLens.css">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="assets/css/theme-color/default-theme.css" rel="stylesheet">
    <!-- Top Slider CSS -->
    <link href="assets/css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="assets/css/style.css" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
  <!-- Top Slider CSS -->
  <link href="assets/css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">
  <link rel="stylesheet" href="assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <link rel="stylesheet" href="assets/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

 

</head>

<body>
  <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
  <header id="aa-header">

    <div class="aa-header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-top-area">
              <div class="aa-header-top-left">
                <div class="cellphone hidden-xs">
                  <p><span class="fa fa-phone"></span>+505 5784-4921</p>
                </div>
              </div>
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">
                  <li><a href="">Mi cuenta</a></li>
                  <li class="hidden-xs"><a href="">Mi carrito</a></li>
                  <li class="hidden-xs"><a href="">Checkout</a></li>

                  <?php if (isset($_SESSION['nombre'])) { ?>
                    <div class="user-info-dropdown">
                      <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                          <span class="user-icon">
                            <img src="assets/img/fotos_perfil/<?php echo  $_SESSION['foto']; ?>" alt="Foto de usuario" width="50" height="" />
                          </span>
                          <span class="user-name" style="font: bold 16px Arial, sans-serif; color:black;"><?php echo  $_SESSION['nombre']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">

                          <a class="dropdown-item" href="index.php?c=login&a=cerrar&id=<?php echo $_SESSION['IdUsuario'] ?>">Log Out</a>

                        </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <li><a href="" data-toggle="modal" data-target="#login-modal">Inciar session</a></li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">

              <div class="aa-logo">
                <img src="assets/img/Logos/logo.png" alt="logo img" width=50>
                <a href="index.php?c=page">

                  <p>Tienda <strong>$EBRA$</strong> <span>Tu socio de compra</span></p>
                </a>

              </div>

              <div class="aa-cartbox">
                <a class="aa-cart-link" href="#">
                  <span class="fa fa-shopping-basket"></span>
                  <span class="aa-cart-title">Carro de compra</span>
                  <span class="aa-cart-notify">2</span>
                </a>
                <div class="aa-cartbox-summary">
                  <ul>
                    <li>
                      <a class="aa-cartbox-img" href="#"><img src="img/woman-small-2.jpg" alt="img"></a>
                      <div class="aa-cartbox-info">
                        <h4><a href="#">Nombre del producto</a></h4>
                        <p>1 x $250</p>
                      </div>
                      <a class="aa-remove-product" href="#"><span class="fa fa-times"></span></a>
                    </li>
                    <li>
                      <a class="aa-cartbox-img" href="#"><img src="img/woman-small-1.jpg" alt="img"></a>
                      <div class="aa-cartbox-info">
                        <h4><a href="#">Nombre producto</a></h4>
                        <p>1 x $250</p>
                      </div>
                      <a class="aa-remove-product" href="#"><span class="fa fa-times"></span></a>
                    </li>
                    <li>
                      <span class="aa-cartbox-total-title">
                        Total
                      </span>
                      <span class="aa-cartbox-total-price">
                        $500
                      </span>
                    </li>
                  </ul>
                  <a class="aa-cartbox-checkout aa-primary-btn" href="">Checkout</a>
                </div>
              </div>
              <!-- / cart box -->
              <!-- search box -->
              <div class="aa-search-box">
                <form action="">
                  <input type="text" name="" id="" placeholder="Buscar ejemplo. 'Hombres' ">
                  <button type="submit"><span class="fa fa-search"></span></button>
                </form>
              </div>
              <!-- / search box -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <section id="menu">
    <div class="container">
      <div class="menu-area">
        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse">
            <!-- Left nav -->
            <ul class="nav navbar-nav">
              <li><a href="index.php">Inicio</a></li>

              <?php foreach ($Categorias['productos'] as $categorias) : ?>

                <li><a href="#"><?php echo $categorias['nombre'] ?><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php foreach ($categorias['subcategorias'] as $subcategoria) : ?>
                      <li><a href="index.php?c=page&a=filtros&id=<?php echo $subcategoria['id']; ?>"><?php echo $subcategoria['nombre']; ?></a></li>

                    <?php endforeach; ?>
                  </ul>
                </li>
              <?php endforeach; ?>

              <li><a href="#">Acerca de nosotros</a>
              <li><a href="index.php?c=page&a=contacto">Contacto</span></a>
            </ul>

          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  </section>