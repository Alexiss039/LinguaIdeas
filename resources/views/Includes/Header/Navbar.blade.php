<head>

  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

 
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="shortcut icon" type="image/png" href="assets/img/fon.png">
  <link href="assets/img/fon.png" rel="icon">
  <link href="assets/img/fon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}">


  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="{{ asset('assets/css/linguaideax.css')}}">

</head>
<div class="modal fade" id="buscarModal" tabindex="-1" role="dialog" aria-labelledby="buscarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="/buscar" method="GET">
        <div class="modal-header">
          <h5 class="modal-title" id="buscarModalLabel">Buscar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input class="form-control" type="search" name="terminos" placeholder="Buscar...">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="{{ url('/') }}"><span>Lingua</span>Ideas</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
        <li> 
            <!-- <form class="form-inline" action="/buscar" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="terminos" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </div>
                </div>
            </form> -->
            <div class="d-flex justify-content-center">
                <button type="button" class="btn-blue mx-auto" data-toggle="modal" data-target="#buscarModal">
                    Buscar
                </button>
            </div>
        </li>
          <li><a href="{{ url('/') }}">Inicio</a></li>

          <li><a href="{{ route('nosotros.index')}}">Nosotros</a></li>

          <li class="dropdown"><a href="#">Actividades <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="{{ route('lecciones.index')}}">Lecciones</a></li>
                <li><a href="{{ route('ejercicios.index')}}">Ejercicios</a></li>
                <li><a href="{{ route('juegos.index')}}">Juegos</a></li>
                <li><a href="{{ route('recursos.index')}}">Recursos</a></li>
                <li><a href="{{ route('pronunciacion.index')}}">Pronunciación</a></li>
                <li><a href="{{ route('gramatica.index')}}">Gramática</a></li>
                <li><a href="{{ route('pruebas.index')}}">Pruebas</a></li>
                <li><a href="{{ route('trucos.index')}}">Trucos</a></li>
              </ul>
          </li>
          <li class="dropdown"><a href="#">Entretenimiento <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="{{ route('videos.index')}}">Videos</a></li>
                <li><a href="{{ route('memes.index')}}">Memes</a></li>
                <li><a href="{{ route('historias.index')}}">Actualidad</a></li>               
              </ul>
          </li>
          <li class="dropdown"><a href="#">Podcast <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="{{ route('temas.index')}}">Temas</a></li>
                <li><a href="{{ route('entrevistas.index')}}">Entrevistas</a></li>
              
              </ul>
          </li>
          <li class="dropdown"><a href="#">Noticias <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="{{ route('examenes.index')}}">Examenes de certificación</a></li>
                <li><a href="{{ route('innovacion.index')}}">Innovación y tendencias</a></li>
                <li><a href="{{ route('eventos.index')}}">Eventos y cursos</a></li>
              </ul>
          </li>
          <li><a href="{{ route('testimonios.index')}}">Comunidad</a></li>
          <li><a href="{{ route('terminos.index')}}">TYC</a></li>
          @if (auth()->check())
          <li><a href="{{ route('login') }}">Panel</a></li>          
          @endif
          

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->


  
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>