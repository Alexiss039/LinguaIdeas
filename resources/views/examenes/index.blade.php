@extends('welcome')

@section('content')


    <!-- ======= About Us Section ======= -->
    <section  class="values">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Lista de examenes</h2>
        </div>

        <div class="row">
            @foreach($examenes as $examen)
              <div class="col-lg-3 mt-4 mt-lg-0 pt-4" data-aos="fade-up" data-aos-delay="400">
                <div class="box">
                  <img src="https://img.freepik.com/vector-gratis/sol-brilla-cielo-azul-nubes-fondo-realista_1284-10467.jpg?w=2000" class="img-fluid" alt="">
                  <h3>{{ $examen->nombre }}</h3>
                  <p>{{ $examen->descripcion }}</p>
                </div>
              </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center pt-5">
            {{ $examenes->links() }}
        </div>

      </div>
    </section>
    <!-- End About Us Section -->

@endsection