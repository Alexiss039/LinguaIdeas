
@extends('welcome')

@section('content')

     
<section  class="values">        

    <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">

        <div class="section-title" data-aos="fade-up">
          <h2>Listado de Juegos</h2>
        </div>      

        <div class="tab-container">
          <div class="tabs">
            <button class="tab btn-tab active" data-target="tab-1">Recursos Educativos</button>
            <button class="tab btn-tab" data-target="tab-2">Multimedia</button>
            <button class="tab btn-tab" data-target="tab-3">Enlaces Educativos</button>
            <!-- <button class="tab btn-tab" data-target="tab-4">Formularios</button> -->
          </div>
  
          <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
            @if (App\Models\Juegos::where('tipo', 'recurso')->count() > 0)
              <div class="row">
                      @foreach($recursos as $recurso)
                        <div class="col-lg-3 mt-4 mt-lg-0 pt-4" data-aos="fade-up" data-aos-delay="400">
                          <div class="box">
                            <a href="{{ route('juegos.show', $recurso) }}" target="_blank">
                            <img src="{{ asset('recursos/' . $recurso->imagen) }}" class="img-fluid" alt="">
                            </a>
                            <h3>{{ $recurso->nombre }}</h3>
                            <p>{{ $recurso->descripcion }}</p>
                            @php
                              $extension = pathinfo($recurso->recurso, PATHINFO_EXTENSION);
                            @endphp
                            @if ($extension == 'pdf')
                              <a class="btn-blue" href="{{ route('juegos.show', $recurso) }}" target="_blank">Ver PDF</a>                              
                            @elseif(isset($recurso->recurso))
                            <a class="btn-blue" href="{{ asset('juegos/' . $recurso->recurso) }}" target="_blank">Ver Documento</a>
                            @else
                            
                            @endif                            
                          </div>
                        </div>
                      @endforeach
              </div>
              <div class="d-flex justify-content-center pt-5">
                   {{ $recursos->links() }}
              </div>
              @else
            <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                <h1>No hay contenido disponible</h1>
            </div>
            @endif
            </div>
            
            <div id="tab-2" class="tab-pane">
            @if (App\Models\Juegos::where('tipo', 'multimedia')->count() > 0)
                <div class="row">
                          @foreach($multimedias as $multimedia)
                            <div class="col-lg-3 mt-4 mt-lg-0 pt-4" data-aos="fade-up" data-aos-delay="400">
                              <div class="box">
                              <?php echo html_entity_decode($multimedia->link); ?>
                                <h3>{{ $multimedia->nombre }}</h3>
                                <p>{{ $multimedia->descripcion }}</p>
                                @if($multimedia->archivo && pathinfo($multimedia->archivo, PATHINFO_EXTENSION) == 'mp3')
                                <audio controls style="width: 100%; display: block;">
                                    <source src="{{ asset('recursos/' . $multimedia->archivo) }}" type="audio/mp3">
                                </audio>
                                @endif
                                @if($multimedia->archivo && pathinfo($multimedia->archivo, PATHINFO_EXTENSION) == 'mp4')
                                  <video controls width="100%" height="250px;">
                                    <source src="{{ asset('recursos/' . $multimedia->archivo) }}" type="video/mp4">
                                  </video>
                                @endif
                              </div>
                            </div>
                          @endforeach
                  </div>
                  <div class="d-flex justify-content-center pt-5">
                      {{ $multimedias->links() }}
                  </div>
                  @else
            <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                <h1>No hay contenido disponible</h1>
            </div>
            @endif
            </div>
            
            <div id="tab-3" class="tab-pane">
            @if (App\Models\Juegos::where('tipo', 'enlace')->count() > 0)
                  <div class="row">
                          @foreach($enlaces as $enlace)
                            <div class="col-lg-3 mt-4 mt-lg-0 pt-4" data-aos="fade-up" data-aos-delay="400">
                              <div class="box">
                                <a href="{{$enlace->imagen}}" target="_blank">
                                <img src="{{ asset('recursos/' . $enlace->imagen) }}" class="img-fluid" alt="">
                                </a>                      
                                <h3>{{ $enlace->nombre }}</h3>
                                <p>{{ $enlace->descripcion }}</p>
                                <a href="{{$enlace->enlace}}" class="btn-blue" target="_blank">Ir al sitio web</a>
                              </div>
                            </div>
                          @endforeach
                  </div>
                  <div class="d-flex justify-content-center pt-5">
                      {{ $enlaces->links() }}
                  </div>
                  @else
            <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                <h1>No hay contenido disponible</h1>
            </div>
            @endif
            </div>
            <!-- <div id="tab-4" class="tab-pane">
            @if (App\Models\Lecciones::where('tipo', 'formulario')->count() > 0)
            <div class="row">
                          @foreach($formularios as $formulario)
                            <div class="col-lg-3 mt-4 mt-lg-0 pt-4" data-aos="fade-up" data-aos-delay="400">
                              <div class="box">
                                <img src="https://img.freepik.com/vector-gratis/sol-brilla-cielo-azul-nubes-fondo-realista_1284-10467.jpg?w=2000" class="img-fluid" alt="">
                                <h3>{{ $formulario->nombre }}</h3>
                                <p>{{ $formulario->descripcion }}</p>
                              </div>
                            </div>
                          @endforeach
                  </div>
                  <div class="d-flex justify-content-center pt-5">
                      {{ $formularios->links() }}
                  </div>
            @else
            <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                <h1>No hay contenido disponible</h1>
            </div>
            @endif
             
            </div> -->
          </div>
        </div>

      </div>
    </section>


</section>


@endsection