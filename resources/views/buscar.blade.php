
@extends('welcome')

@section('content')

     
<section class="values">
    <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">      
        
      <div class="section-title" data-aos="fade-up">
          <h2>Resultados de la busqueda</h2>
        </div>      

            @if(count($resultados) > 0)
                  <div class="row">
                          @foreach($resultados as $resultado)
                          @if(strpos(strtolower($resultado->nombre), strtolower($terminos)) !== false || strpos(strtolower($resultado->descripcion), strtolower($terminos)) !== false )
                            <div class="col-lg-3 mt-4 mt-lg-0 pt-4" data-aos="fade-up" data-aos-delay="400">
                              <div class="box">
                                <h5>{{ $resultado->tipo }}</h5>
                                @if($resultado->link)
                                <?php echo html_entity_decode($resultado->link); ?>
                                @else

                                @endif
                                @if($resultado instanceof \App\Models\Lecciones && $resultado->imagen)
                                <a href="{{ route('lecciones.show', $recurso) }}" target="_blank">
                                    <img src="{{ asset('recursos/' . $recurso->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado instanceof \App\Models\Ejercicios && $resultado->imagen)
                                <a href="{{ route('ejercicios.show', $recurso) }}" target="_blank">
                                    <img src="{{ asset('recursos/' . $recurso->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @else
                           
                                @endif   
                                <h3>{{ $resultado->nombre }}</h3>
                                <p class="description">{{ $resultado->descripcion }}</p>                          
                                @if ($resultado instanceof \App\Models\Lecciones && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue" href="{{ route('lecciones.show', $recurso) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado instanceof \App\Models\Ejercicios && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue" href="{{ route('ejercicios.show', $recurso) }}" target="_blank">Ver PDF</a>
                                @else
                     
                                @endif
                                @if($resultado->archivo && pathinfo($resultado->archivo, PATHINFO_EXTENSION) == 'mp3')
                                <audio controls style="width: 100%; display: block;">
                                    <source src="{{ asset('recursos/' . $resultado->archivo) }}" type="audio/mp3">
                                </audio>
                                @elseif($resultado->archivo && pathinfo($resultado->archivo, PATHINFO_EXTENSION) == 'mp4')
                                  <video controls width="100%" height="250px;">
                                    <source src="{{ asset('recursos/' . $resultado->archivo) }}" type="video/mp4">
                                  </video>
                                @else
                    
                                @endif
                                @if($resultado->enlace)
                                <a href="{{$resultado->enlace}}" class="btn-blue" target="_blank">Ir al sitio web</a>
                                @else
                                 
                                @endif
                              </div>
                            </div>
                            @endif
                          @endforeach
                  </div>
                  <div class="d-flex justify-content-center pt-5">
                    {{ $resultados->appends(['terminos' => $terminos])->links() }}
                  </div>
            @else
            <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                <h1>No se encontraron resultados</h1>
            </div>
            @endif
      </div>
    </section>
</section>


@endsection