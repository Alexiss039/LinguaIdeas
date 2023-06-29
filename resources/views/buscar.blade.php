
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
                                <h5 class="pb-1">{{ $resultado->tipo }}</h5>
                                @if($resultado->link)
                                <?php echo html_entity_decode($resultado->link); ?>
                                @else

                                @endif
                                @if($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'lecciones')
                                <a href="{{ route('lecciones.show', $resultado->id) }}" target="_blank">
                                <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'ejercicios')
                                <a href="{{ route('ejercicios.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'juegos')
                                <a href="{{ route('juegos.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'recursos')
                                <a href="{{ route('recursos.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'pronunciacion')
                                <a href="{{ route('pronunciacion.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'gramatica')
                                <a href="{{ route('gramatica.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'pruebas')
                                <a href="{{ route('pruebas.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'trucos')
                                <a href="{{ route('trucos.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'memes')
                                <a href="{{ route('memes.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'historias')
                                <a href="{{ route('historias.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'temas')
                                <a href="{{ route('temas.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'entrevistas')
                                <a href="{{ route('entrevistas.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'examenes')
                                <a href="{{ route('examenes.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'innovacion')
                                <a href="{{ route('innovacion.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @elseif($resultado->imagen && Storage::disk('public')->exists('recursos/' . $resultado->imagen) && $resultado->tabla == 'eventos')
                                <a href="{{ route('eventos.show', $resultado->id) }}" target="_blank">
                                    <img src="{{ asset('storage/recursos/' . $resultado->imagen) }}" class="img-fluid" alt="">
                                </a>
                                @else

                                @endif
                               
                                <h3>{{ $resultado->nombre }}</h3>
                                <p class="description">{{ $resultado->descripcion }}</p>
                                @php
                                  $extension = pathinfo($resultado->recurso, PATHINFO_EXTENSION);
                                @endphp
                                @if ($resultado->tabla == 'lecciones' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('lecciones.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'ejercicios' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('ejercicios.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'juegos' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('juegos.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'recursos' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('recursos.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'pronunciacion' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('pronunciacion.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'gramatica' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('gramatica.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'pruebas' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('pruebas.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'trucos' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('trucos.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'memes' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('memes.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'historias' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('historias.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'temas' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('temas.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'entrevistas' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('entrevistas.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'examenes' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('examenes.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'innovacion' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('innovacion.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @elseif($resultado->tabla == 'eventos' && $resultado->recurso && $extension == 'pdf')
                                <a class="btn-blue pb-1" href="{{ route('eventos.show', $resultado->id) }}" target="_blank">Ver PDF</a>
                                @else
                     
                                @endif
                                @if($resultado->archivo && pathinfo($resultado->archivo, PATHINFO_EXTENSION) == 'mp3')
                                <audio controls style="width: 100%; display: block;">
                                <source src="{{ asset('storage/recursos/' . $resultado->archivo) }}" type="audio/mp3"> 
                                </audio>
                                @elseif($resultado->archivo && pathinfo($resultado->archivo, PATHINFO_EXTENSION) == 'mp4')
                                  <video controls width="100%" height="250px;">
                                  <source src="{{ asset('storage/recursos/' . $resultado->archivo) }}" type="video/mp4">
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