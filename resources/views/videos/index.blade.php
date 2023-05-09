@extends('welcome')

@section('content')


    <!-- ======= About Us Section ======= -->
    <section  class="values">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Lista de videos</h2>

          <p>
          Disfruta de nuestra selección de videos en inglés que te harán reír y aprender al mismo tiempo.
          Desde cortometrajes cómicos hasta sketches y animaciones, estos videos te ayudarán a
          sumergirte en el idioma de una manera relajada y divertida. Y si quieres ir más allá, sigue nuestros
          consejos de cómo sacar el máximo de cada video según temática y elementos lingüísticos
          involucrados.
          </p>
        </div>

        <div class="row">
            @foreach($videos as $video)
              <div class="col-lg-3 mt-4 mt-lg-0 pt-4" data-aos="fade-up" data-aos-delay="400">
                <div class="box">
                <?php echo html_entity_decode($video->link); ?>

                  <!-- <iframe width="100%" height="250" src="https://www.youtube.com/embed/feEus_LgIz4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
                 
                  <!-- <img src="https://img.freepik.com/vector-gratis/sol-brilla-cielo-azul-nubes-fondo-realista_1284-10467.jpg?w=2000" class="img-fluid" alt=""> -->
                  <h3>{{ $video->nombre }}</h3>
                  <p>{{ $video->descripcion }}</p>
                </div>
              </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center pt-5">
            {{ $videos->links() }}
        </div>

      </div>
    </section>
    <!-- End About Us Section -->

@endsection