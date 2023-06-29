<?php

$leccion = \App\Models\Lecciones::count();
$ejercicio = \App\Models\Ejercicios::count();

$actividades = $leccion + $ejercicio;

?>
<head>

</head>
@extends('welcome')

@section('content')
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">¡Aprende inglés fácil y rápido!</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">¡Bienvenido a nuestro método divertido para aprender inglés!</h2>
          <div style="display: flex; justify-content: center;">
            <button id="abrir-modal" class="btn-get-started scrollto">Comencemos</button>
            <div id="mi-modal" class="ventana" style="display: none;">
              <div class="ventana-contenido">
                <!-- Contenido del modal -->
                <span class="cerrar">&times;</span>
                <div id="video-container">
                <video id="video" controls style="width: 100%; height: 375px;">
                    <source src="assets/videos/bienvenida.mp4" type="video/mp4">
                    <!-- También puedes agregar otros formatos de video compatibles aquí -->
                </video>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
          <img src="assets/img/fon.png" class="img-fluid animated" alt="" style="border-radius:80px;">
        </div>
      </div>
    </div>

  </section>
  <!-- End Hero -->

  <main id="main">


    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>¿Quiénes somos?</h2>
        </div>

        <div class="row content">
            <p>
        Bienvenido a LinguaIdeas, una plataforma en línea innovadora y accesible para aprender idiomas y
        conectar con diversas culturas. Nuestra misión es ayudar a los usuarios a desarrollar habilidades
        lingüísticas en un entorno seguro y placentero, aprovechando al máximo los recursos en línea y
        adaptándose a diferentes estilos de aprendizaje.
            </p>

            <p>
      Nuestro equipo de profesionales altamente calificados trabaja conjuntamente para proporcionar
      recursos y actividades atractivas, como videos, juegos, ejercicios y contenido cultural. En
      LinguaIdeas, nos enfocamos en ofrecer estrategias de estudio transformadoras que se ajusten a
      los estilos de aprendizaje individuales de nuestros usuarios, garantizando una experiencia de
      aprendizaje más efectiva y satisfactoria.
            </p>

            <div class="container" style="text-align:center;">
            <a href="{{ route('nosotros.index')}}" class="btn-learn-more" style="width:auto; text-align:center;">Leer Más</a>
            </div>
        </div>

      </div>
    </section>
    <!-- End About Us Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container">

        <div class="row justify-content-center">
          <!-- <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-xl-start" data-aos="fade-right" data-aos-delay="150">
            <img src="assets/img/counts-img.svg" alt="" class="img-fluid">
          </div> -->

          <div class="col-xl-10 d-flex align-items-stretch pt-4 pt-xl-0" data-aos="fade-left" data-aos-delay="300">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                  <i class="bi bi-activity" style="color: rgb(97, 203, 229);"></i>
                    <span data-purecounter-start="0" data-purecounter-end="{{ $acti }}" data-purecounter-duration="1" class="purecounter"></span>
                    <p><strong>Actividades</strong> disponibles para mejorar tus habilidades en el idioma de manera efectiva.</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                  <i class="bi bi-collection-play" style="color: rgb(97, 203, 229);"></i>
                    <span data-purecounter-start="0" data-purecounter-end=" {{ $entretenimiento }}" data-purecounter-duration="1" class="purecounter"></span>
                    <p><strong>Entretenimientos</strong> disponibles para mantenerte entretenido mientras aprendes.</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                  
                  <i class="bi bi-mic-fill" style="color: rgb(97, 203, 229);"></i>
                    <span data-purecounter-start="0" data-purecounter-end=" {{ $podcast }}" data-purecounter-duration="1" class="purecounter"></span>
                    <p><strong>Podcast</strong> de episodios temáticos llenos de consejos prácticos y experiencias inspiradoras.</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                  <i class="bi bi-newspaper" style="color: rgb(97, 203, 229);"></i>
                    <span data-purecounter-start="0" data-purecounter-end=" {{ $noticias }}" data-purecounter-duration="1" class="purecounter"></span>
                    <p><strong>Noticias</strong> sobre exámenes de certificación, innovaciones y tendencias educativas.</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- End .content-->
          </div>
        </div>

      </div>
    </section>
    <!-- End Counts Section -->

    <!-- ======= More Services Section ======= -->
    <section id="more-services" class="more-services">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Aprende inglés</h2>
          <!-- <p>Aprender inglés nunca ha sido tan fácil. En nuestra página te proporcionamos herramientas y trucos útiles sobre cómo aprender inglés. Descubre cómo puedes mejorar tu fluidez, comprensión y expresión en inglés con nosotros.</p> -->
            <p>En LinguaIdeas, creemos que aprender inglés puede ser una experiencia emocionante y
            enriquecedora. Nuestra sección de Actividades ofrece una amplia variedad de lecciones, ejercicios,
            juegos, recursos y trucos únicos y creativos que te ayudarán a mejorar tus habilidades en el idioma
            de manera efectiva. Explora nuestras actividades de pronunciación, gramática y pruebas para
            llevar tu inglés al siguiente nivel. Contamos con propuestas propias para potenciar tus
            oportunidades de aprendizaje, además te brindamos los mejores consejos para sacar el máximo
            provecho a los recursos y herramientas disponibles en línea.</p>
        </div>

        <div class="row">
          <div class="col-md-6 d-flex align-items-stretch">
            <div class="card" style='background-image: url("assets/img/Lecciones.gif");' data-aos="fade-up" data-aos-delay="100">
              <a href="{{ route('lecciones.index')}}">
                <div class="card-body">
                  <h5 class="card-title">Lessons</h5>
                  <!-- <p class="card-text">Lecciones interactivas en video para aprender inglés</p> -->
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="card" style='background-image: url("assets/img/Ejercicios.gif");' data-aos="fade-up" data-aos-delay="200">
              <a href="{{ route('ejercicios.index')}}">  
                <div class="card-body">
                  <h5 class="card-title">Exercises</h5>
                  <!-- <p class="card-text">Ejercicios de gramática y vocabulario en inglés</p> -->
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/Juegos.gif");' data-aos="fade-up" data-aos-delay="100">
              <a href="{{ route('juegos.index')}}">  
                <div class="card-body">
                  <h5 class="card-title">Games</h5>
                  <!-- <p class="card-text">Juegos en línea y apps para aprender inglés</p>                 -->
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/Recursos.gif");' data-aos="fade-up" data-aos-delay="200">
              <a href="{{ route('recursos.index')}}">  
                <div class="card-body">
                  <h5 class="card-title">Resources</h5>
                  <!-- <p class="card-text">Recursos gratuitos en inglés para estudiantes</p>               -->
                </div>
              </a>
            </div>
          </div>
        </div>

        <div class="row pt-4">
          <div class="col-md-6 d-flex align-items-stretch">
            <div class="card" style='background-image: url("assets/img/Pronunciacion.gif");' data-aos="fade-up" data-aos-delay="100">
              <a href="{{ route('pronunciacion.index')}}">  
                <div class="card-body">
                  <h5 class="card-title">Pronunciation</h5>
                  <!-- <p class="card-text">Lecciones interactivas en video para aprender inglés</p>             -->
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="card" style='background-image: url("assets/img/Gramatica.gif");' data-aos="fade-up" data-aos-delay="200">
              <a href="{{ route('gramatica.index')}}">  
                <div class="card-body">
                  <h5 class="card-title">Grammar</h5>
                  <!-- <p class="card-text">Ejercicios de gramática y vocabulario en inglés</p>                 -->
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/Pruebas.gif");' data-aos="fade-up" data-aos-delay="100">
               <a href="{{ route('pruebas.index')}}">    
                <div class="card-body">
                  <h5 class="card-title">Tests</h5>
                  <!-- <p class="card-text">Juegos en línea y apps para aprender inglés</p>               -->
                </div>
               </a>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/Trucos.gif");' data-aos="fade-up" data-aos-delay="200">
               <a href="{{ route('trucos.index')}}">   
                <div class="card-body">
                  <h5 class="card-title">Tricks</h5>
                  <!-- <p class="card-text">Recursos gratuitos en inglés para estudiantes</p>                 -->
                </div>
               </a>
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- End More Services Section -->

      <!-- ======= Services Section ======= -->
      <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2 class="no-before no-after">Entretenimiento en inglés para todos</h2>
          <!-- <p>¿Quieres divertirte en inglés? Encuentra contenido entretenido y viral en inglés en nuestra sección de entretenimiento. Tenemos videos, noticias, memes y más, todo para que puedas disfrutar mientras mejoras tu inglés.</p> -->
          <p>Aprender inglés no tiene por qué ser aburrido. En LinguaIdeas, te presentamos una selección de
          videos, memes e historias en inglés disponibles en línea para mantenerte entretenido mientras
          aprendes. Sumérgete en el idioma con nuestras recomendaciones sobre cómo aprender de
          manera entretenida y descubre cómo el aprendizaje del inglés puede ser tan divertido como
          cualquier otra actividad de ocio.</p>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-4 align-items-stretch mb-5 mb-lg-0">
            <a href="{{ route('videos.index')}}">
                <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                  <div class="icon d-flex justify-content-center"><i class="bi bi-camera-video"></i></div>
                  <h4 class="title" style="text-align:center;">Videos</h4>
                  <!-- <p class="description">Gramática en inglés explicada de forma sencilla</p> -->
                </div>
            </a>
          </div>

          <div class="col-md-6 col-lg-4 align-items-stretch mb-5 mb-lg-0">
            <a href="{{ route('memes.index')}}">  
              <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                <div class="icon d-flex justify-content-center"><i class="bi bi-emoji-sunglasses"></i></div>
                <h4 class="title" style="text-align:center;">Memes</h4>
                <!-- <p class="description">Vocabulario en inglés esencial y útil</p> -->
              </div>
            </a>
          </div>

          <div class="col-md-6 col-lg-4 align-items-stretch mb-5 mb-lg-0">
            <a href="{{ route('historias.index')}}">    
                <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                  <div class="icon d-flex justify-content-center"><i class='bi bi-layout-text-window-reverse'></i></div>
                  <h4 class="title" style="text-align:center;">Actualidad</h4>
                  <!-- <p class="description">Consejos efectivos para aprender inglés de forma autodidacta</p> -->
                </div>
            </a>
          </div>

        </div>

      </div>
    </section>
    <!-- End Services Section -->

    <!-- ======= Features Section ======= -->
    <!-- <section id="features" class="features">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Entretenimiento en inglés para todos</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="300">
          <div class="col-lg-3 col-md-4">
            <div class="icon-box">
              <i class="ri-store-line" style="color: #ffbb2c;"></i>
              <h3><a href="">Videos</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="ri-bar-chart-box-line" style="color: #5578ff;"></i>
              <h3><a href="">Memes</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="ri-calendar-todo-line" style="color: #e80368;"></i>
              <h3><a href="">Historias</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-lg-0">
            <div class="icon-box">
              <i class="ri-paint-brush-line" style="color: #e361ff;"></i>
              <h3><a href="">Magni Dolores</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-database-2-line" style="color: #47aeff;"></i>
              <h3><a href="">Nemo Enim</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-gradienter-line" style="color: #ffa76e;"></i>
              <h3><a href="">Eiusmod Tempor</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-file-list-3-line" style="color: #11dbcf;"></i>
              <h3><a href="">Midela Teren</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-price-tag-2-line" style="color: #4233ff;"></i>
              <h3><a href="">Pira Neve</a></h3>
            </div>
          </div>
          
          
        </div>

      </div>
    </section> -->
    <!-- End Features Section -->

    <!-- ======= Services Section ======= -->
    <section id="servi" class="servi section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title" data-aos="fade-up">
          <h2 class="no-before no-after">Podcast para aprender inglés</h2>
          <!-- <p>¡Escucha los mejores podcasts en inglés en nuestra página! Tenemos una selección cuidadosa de podcasts de alta calidad y relevancia para mejorar tu inglés mientras disfrutas de contenido interesante.</p> -->
          <p>El Podcast de LinguaIdeas es tu fuente de información y entretenimiento en el mundo del
          aprendizaje del inglés. Escucha nuestras entrevistas con diversos actores de la enseñanza-
          aprendizaje del idioma y disfruta de episodios temáticos llenos de consejos prácticos y
          experiencias inspiradoras. Aprende inglés mientras te diviertes, en cualquier momento y lugar.</p>
        </div>

        <div class="row" style="justify-content:space-around;">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <a href="{{ route('temas.index')}}">
              <div class="icon-box iconbox-blue">
                <div class="icon">
                  <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                    <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174"></path>
                  </svg>
                  <i class='bi bi-headphones'></i>
                </div>
                <h4>Temas interesantes para practicar listening</h4>
          
              </div>
            </a>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <a href="{{ route('entrevistas.index')}}">  
              <div class="icon-box iconbox-blue">
                <div class="icon">
                  <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                    <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,582.0697525312426C382.5290701553225,586.8405444964366,449.9789794690241,525.3245884688669,502.5850820975895,461.55621195738473C556.606425686781,396.0723002908107,615.8543463187945,314.28637112970534,586.6730223649479,234.56875336149918C558.9533121215079,158.8439757836574,454.9685369536778,164.00468322053177,381.49747125262974,130.76875717737553C312.15926192815925,99.40240125094834,248.97055460311594,18.661163978235184,179.8680185752513,50.54337015887873C110.5421016452524,82.52863877960104,119.82277516462835,180.83849132639028,109.12597500060166,256.43424936330496C100.08760227029461,320.3096726198365,92.17705696193138,384.0621239912766,124.79988738764834,439.7174275375508C164.83382741302287,508.01625554203684,220.96474134820875,577.5009287672846,300,582.0697525312426"></path>
                  </svg>
                  <i class='bi bi-people'></i>
                </div>
                <h4>Entrevistas con hablantes nativos y expertos en la enseñanza del inglés</h4>
             
              </div>
            </a>
          </div>

          <!-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-pink">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-tachometer"></i>
              </div>
              <h4><a href="">Trucos y consejos para aprender inglés más rápido</a></h4>
              <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
            </div>
          </div> -->

        </div>

      </div>
    </section>
    <!-- End Services Section -->

    
    <!-- ======= Services Section ======= -->
    <section id="servicio" class="servicio">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2 class="no-before no-after">Noticias y actualizaciones</h2>
          <!-- <p>En nuestra sección de noticias, te mantendremos actualizado sobre las últimas tendencias y novedades en pruebas de suficiencia de inglés y cursos de inglés. Descubre las mejores formas de prepararte y mejorar tu inglés para lograr tus objetivos académicos y profesionales.</p> -->
          <p>Mantente informado sobre las últimas novedades en el aprendizaje del inglés con nuestra sección
          de Noticias. Aquí encontrarás información actualizada sobre exámenes de certificación,
          innovaciones y tendencias educativas como el aprendizaje con herramientas de inteligencia
          artificial, al igual que eventos y cursos que te ayudarán a mejorar tus habilidades en el idioma.
          Lengua Ideas te mantiene al tanto de todo lo que necesitas saber para tener éxito en tu camino
          hacia la fluidez en inglés.</p>
        </div>

        <div class="row">

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <a href="{{ route('examenes.index')}}">
              <div class="icon-box">
                <div class="icon"><i class='bi bi-card-checklist'></i></div>
                <h4><span>Exámenes de certificación (IELTS, TOEFL, Cambridge)</span> </h4>
    
              </div>
            </a>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <a href="{{ route('innovacion.index')}}">  
              <div class="icon-box">
                <div class="icon"><i class='bi bi-magic'></i></div>
                <h4><span> Innovaciones y tendencias en la enseñanza del inglés</span></h4>
         
              </div>
            </a>  
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <a href="{{ route('eventos.index')}}">  
              <div class="icon-box">
                <div class="icon"><i class='bi bi-calendar4-event'></i></div>
                <h4><span> Eventos y cursos de inglés online</span></h4>

              </div>
            </a>  
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->


    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Comunidad</h2>
          <!-- <p>Únete a nuestra comunidad de estudiantes de inglés y comparte tus trabajos en inglés. Obtén comentarios y sugerencias para mejorar tus habilidades lingüísticas.</p> -->
          <p>Únete a nuestra vibrante Comunidad de LinguaIdeas, un espacio donde estudiantes y entusiastas
          del inglés de todo el mundo se reúnen para compartir sus experiencias, trabajos y consejos. En
          nuestra comunidad, podrás obtener valiosos comentarios y sugerencias para mejorar tus
          habilidades lingüísticas, al mismo tiempo que te conectas con personas que comparten tus
          intereses y pasión por el aprendizaje del inglés. Participa en discusiones inspiradoras, intercambia
          recursos útiles y descubre nuevas ideas para llevar tu inglés al siguiente nivel. ¡Súmate a
          LinguaIdeas y forma parte de una red global de aprendices y amantes del inglés!</p>
        </div>

        <iframe src="https://linguaideas.blogspot.com/" frameborder="0" width="100%" height="700px;"></iframe>

      </div>
    </section>
    <!-- End Testimonials Section -->



    <!-- ======= F.A.Q Section ======= -->
    <section id="faq" class="faq">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2 class="no-before no-after">Preguntas y respuestas frecuentes</h2>
        </div>

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>¿Cuánto tiempo se tarda en aprender inglés?</h4>
          </div>
          <div class="col-lg-7">
            <p>
            El tiempo que se tarda en aprender inglés varía según diversos factores, como
la dedicación, el tiempo de estudio diario, la habilidad lingüística y la experiencia previa
con otros idiomas. En promedio, un estudiante puede alcanzar un nivel intermedio en 6
meses a un año, estudiando de manera constante y comprometida.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>¿Cuál es la mejor manera de aprender inglés?</h4>
          </div>
          <div class="col-lg-7">
            <p>
            No existe una única &quot;mejor&quot; manera de aprender inglés, ya que cada persona
tiene diferentes estilos de aprendizaje y preferencias. Sin embargo, algunas estrategias
efectivas incluyen la inmersión en el idioma, la práctica constante, el uso de materiales
auténticos, el aprendizaje en contextos reales y la interacción con hablantes nativos.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>¿Es necesario viajar a un país de habla inglesa para aprender inglés?</h4>
          </div>
          <div class="col-lg-7">
            <p>
            Aunque viajar a un país de habla inglesa puede ser beneficioso para la
inmersión en el idioma y la práctica con hablantes nativos, no es estrictamente necesario.
Con la ayuda de recursos en línea, plataformas como LinguaIdeas y la comunicación con
hablantes nativos a través de Internet, es posible aprender inglés de manera efectiva sin
salir de tu país.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>¿Qué nivel de inglés necesito para estudiar o trabajar en un país angloparlante?</h4>
          </div>
          <div class="col-lg-7">
            <p>
            Generalmente, se requiere un nivel intermedio-alto o avanzado de inglés (B2 o
C1 según el Marco Común Europeo de Referencia para las Lenguas) para estudiar o
trabajar en un país angloparlante. Sin embargo, los requisitos específicos varían según la
institución o empresa y el programa o puesto al que se postule.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>¿Cómo puedo mejorar mi pronunciación en inglés?</h4>
          </div>
          <div class="col-lg-7">
            <p>
            Para mejorar la pronunciación en inglés, es importante practicar regularmente
y escuchar a hablantes nativos a través de grabaciones, videos o conversaciones en vivo.
Además, prestar atención a los sonidos problemáticos y practicarlos de manera aislada,
junto con ejercicios de entonación y ritmo, puede ayudar a mejorar la pronunciación.
            </p>
          </div>
        </div>
        <!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>¿Cómo puedo expandir mi vocabulario en inglés?</h4>
          </div>
          <div class="col-lg-7">
            <p>
            Para expandir el vocabulario en inglés, es útil leer y escuchar materiales
auténticos en inglés, como libros, artículos, podcasts y videos. Además, aprender palabras
en contexto y agruparlas por tema, así como utilizar técnicas de memorización como
tarjetas de estudio y aplicaciones, puede facilitar la adquisición de nuevo vocabulario.
            </p>
          </div>
        </div>
        <!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>¿Cuándo debo empezar a hablar inglés?</h4>
          </div>
          <div class="col-lg-7">
            <p>
            Es aconsejable empezar a hablar inglés desde el principio del proceso de
aprendizaje. Practicar la expresión oral, incluso en un nivel básico, ayuda a desarrollar la
fluidez y la confianza en el idioma. Puedes comenzar hablando contigo mismo, practicando
con amigos, compañeros de clase o tutores, o participando en intercambios lingüísticos en
línea.
            </p>
          </div>
        </div>
        <!-- End F.A.Q Item-->

      </div>
    </section>
    <!-- End F.A.Q Section -->

 <!-- Banner de cookies -->
 <div class="cookie-banner">
        <p>Este sitio web utiliza cookies para ofrecerte una mejor experiencia. Al continuar utilizando este sitio, aceptas nuestro uso de cookies.</p>
        <button onclick="aceptarCookies()">Aceptar</button>
        <button><a href="{{ route('terminos.politica')}}">Política de datos</a></button>
    </div>
  </main>
  <!-- End #main -->
  
  <!-- localStorage.removeItem("cookiesAccepted"); -->
    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var cookieBanner = document.querySelector(".cookie-banner");
            if (!localStorage.getItem("cookiesAccepted")) {
                cookieBanner.classList.add("active");
            }
        });

        function aceptarCookies() {
            localStorage.setItem("cookiesAccepted", true);
            document.querySelector(".cookie-banner").style.display = "none";
        }
    </script>
  <script>
    var boton = document.getElementById("abrir-modal");
    var modal = document.getElementById("mi-modal");

    boton.onclick = function() {
        modal.style.display = "block";
        reproducirVideo();
    }

    function reproducirVideo() {
        var video = document.getElementById("video");
        video.play();
    }

    var cerrarBoton = document.getElementsByClassName("cerrar")[0];
    cerrarBoton.onclick = function() {
        var video = document.getElementById("video");
        video.pause();
        modal.style.display = "none";
    }
</script>
  @endsection