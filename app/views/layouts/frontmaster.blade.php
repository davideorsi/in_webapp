<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Intempesta Noctis</title>
  <meta name="description" content="gioco di ruolo dal vivo">
  <meta name="author" content="Intempesta Noctis - Il Borgo e La Ruota">
  <meta property="og:title" content="Intempesta Noctis" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.intempestanoctis.it" />
  <!--<meta property="og:image" content="https://www.intempestanoctis.it/img/thumb.jpg"  /> -->
  <!--<meta property="og:image" content="https://www.intempestanoctis.it/img/thumb1.jpg" /> -->
  <!--<meta property="og:image" content="https://www.intempestanoctis.it/img/thumb2.jpg" /> -->
  <meta property="og:image" content="https://www.intempestanoctis.it/img/thumb3.jpg" />
  <meta property="og:image" content="https://www.intempestanoctis.it/img/thumb4.jpg" />
  <meta property="og:image" content="https://www.intempestanoctis.it/img/thumb5.jpg" />
  <!--<meta property="og:image" content="https://www.intempestanoctis.it/img/thumb6.jpg" /> -->
  <meta property="og:image" content="https://www.intempestanoctis.it/img/thumb7.jpg" />
  <meta property="og:image" content="https://www.intempestanoctis.it/img/thumb8.jpg" />
  <meta property="og:description" content="Gioco di Ruolo dal Vivo nel Ducato di Parma di Inizio Ottocento" />
  <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicons -->
  <link href="/favicon.ico" rel="icon">
  <link rel="shortcut icon" href="/favicon.ico">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Vendor CSS Files -->
  {{ HTML::style('css/frontpage/aos/aos.css');}}
  {{ HTML::style('css/frontpage/bootstrap/bootstrap.min.css');}}
  {{ HTML::style('css/frontpage/glightbox/glightbox.min.css');}}
  {{ HTML::style('css/frontpage/swiper/swiper-bundle.min.css');}}
  {{ HTML::style('css/frontpage/bootstrap-icons/bootstrap-icons.css');}}
  <!-- Template Main CSS File -->
  {{ HTML::style('css/frontpage/style.css');}}
  @section('CSS')
  @show

  <!-- =======================================================
  * Template Name: TheEvent - v4.7.0
  * Template URL: https://bootstrapmade.com/theevent-conference-event-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center ">
    <div class="container-fluid container-xxl d-flex align-items-center">

      <div id="logo" class="me-auto">
        <!-- Uncomment below if you prefer to use a text logo -->
        <!-- <h1><a href="index.html">The<span>Event</span></a></h1>-->
        <a href={{URL::to('/front')}} class="scrollto"><img src={{'/images/front/IN_White_WEB_trasp.png'}} alt="" title=""></a>
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="/front#hero">Overture</a></li>
          <li><a class="nav-link scrollto" href="/front#about">Introduzione</a></li>
          <!--<li><a class="nav-link scrollto" href="#eventi">Eventi</a></li>-->
          <li><a class="nav-link scrollto" href="/front#gallery">Eventi</a></li>
          <li><a class="nav-link scrollto" href="/front#ambientazione">Ambientazione</a></li>
          <li><a class="nav-link scrollto" href="/front#regolamento">Regolamento</a></li>
          <li><a class="nav-link scrollto" href="/front#partecipa">Partecipa</a></li>

          <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Drop Down 1</a></li>
            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
              <ul>
                <li><a href="#">Deep Drop Down 1</a></li>
                <li><a href="#">Deep Drop Down 2</a></li>
                <li><a href="#">Deep Drop Down 3</a></li>
                <li><a href="#">Deep Drop Down 4</a></li>
                <li><a href="#">Deep Drop Down 5</a></li>
              </ul>
            </li>
            <li><a href="#">Drop Down 2</a></li>
            <li><a href="#">Drop Down 3</a></li>
            <li><a href="#">Drop Down 4</a></li>
          </ul>
        </li> -->
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

	    <a class="partecipa scrollto" href={{URL::to('/')}}>Login</a>

    </div>
  </header><!-- End Header -->
  <body>
@yield('content')
  </body>
  <!-- ======= Footer ======= -->
  <footer id="footer">



    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>TheEvent</strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!--
        All the links in the footer should remain intact.
        You can delete the links only if you purchased the pro version.
        Licensing information: https://bootstrapmade.com/license/
        Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=TheEvent
      -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  {{ HTML::script('js/frontpage/aos/aos.js');}}
  {{ HTML::script('js/frontpage/bootstrap/bootstrap.bundle.min.js');}}
  {{ HTML::script('js/frontpage/glightbox/glightbox.min.js');}}
  {{ HTML::script('js/frontpage/swiper/swiper-bundle.min.js');}}
  {{ HTML::script('js/frontpage/php-email-form/validate.js');}}
  <!-- Template Main JS File -->
  {{ HTML::script('js/frontpage/main.js');}}
  @section('JS')
  @show

  <script>
    @section('Scripts')
    @show
  </script>
</body>

</html>
