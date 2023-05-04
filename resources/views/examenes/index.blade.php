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
                  <h3>{{ $examen->nombre }}</h3>
                  <p>{{ $examen->descripcion }}</p>
                  <a href="{{$examen->enlace}}" class="btn-blue" target="_blank">Ir al sitio web</a>
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