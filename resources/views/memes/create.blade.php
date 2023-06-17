
@extends('Includes.panel.menu')  

@section('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
    

<div class="tab-container">
          <div class="tabs">
            <button class="tab btn-tab active" data-target="tab-1">Recursos Educativos</button>
            <button class="tab btn-tab" data-target="tab-2">Multimedia</button>
            <button class="tab btn-tab" data-target="tab-3">Enlaces Educativos</button>
          </div>
  
          <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="row d-flex justify-content-around mt-6">
                  <div class="col-6">
                      <div class="card mb-4">
                          <div class="card-header pb-0">
                            <h6>Registro de Memes</h6>
                          </div>
                          <div class="d-flex justify-content-end px-5">
                                      <a href="{{ route('memes.lista')}}" class="btn-get-started">
                                          <i class="fas fa-chevron-left"></i>
                                          Regresar</a>
                          </div>
                          <div class="card-body px-5 pt-0 pb-2">
                              @if($errors->any())
                                      @foreach($errors->all() as $error)
                                      <div class="alert alert-danger" role="alert">
                                          {{ $error }}
                                      </div>
                                      @endforeach
                              @endif
                              <form action="{{ route('memes.store')}}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                          <!-- <label>Tipo</label> -->
                                          <div class="form-group">
                                            <input type="hidden" type="text" class="form-control" name="tipo" value="recurso">
                                          </div>
                                          <label>Nombres</label>
                                          <div class="form-group">
                                            <input id="nombre" type="text" class="form-control" name="nombre" placeholder="Ingrese nombre" value="{{ old('nombre') }}" required>
                                          </div>

                                          <label>Descripción</label>
                                          <div class="form-group">
                                            <input id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Ingrese descripción" value="{{ old('descripcion') }}" required>
                                          </div>
                                          
                                          <label>Imagen</label>
                                          <div class="form-group">
                                            <input type="file" class="form-control" name="imagen">
                                          </div>

                                          <label>Recurso</label>
                                          <div class="form-group">
                                            <input type="file" class="form-control" name="recurso">
                                          </div>
                                        
                                          <div class="d-flex justify-content-around">
                                          <button type="submit" class="btn-get-started">Registrar meme</button>
                                          </div>                
                              </form>
                          </div>
                      </div>
                    </div>
                </div>        
            </div>
            
            <div id="tab-2" class="tab-pane">
            <div class="row d-flex justify-content-around mt-6">
                  <div class="col-6">
                      <div class="card mb-4">
                          <div class="card-header pb-0">
                            <h6>Registro de Memes</h6>
                          </div>
                          <div class="d-flex justify-content-end px-5">
                                      <a href="{{ route('memes.lista')}}" class="btn-get-started">
                                          <i class="fas fa-chevron-left"></i>
                                          Regresar</a>
                          </div>
                          <div class="card-body px-5 pt-0 pb-2">
                              @if($errors->any())
                                      @foreach($errors->all() as $error)
                                      <div class="alert alert-danger" role="alert">
                                          {{ $error }}
                                      </div>
                                      @endforeach
                              @endif
                              <form action="{{ route('memes.store')}}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                          <!-- <label>Tipo</label> -->
                                          <div class="form-group">
                                            <input type="hidden" type="text" class="form-control" name="tipo" value="multimedia">
                                          </div>
                                          <label>Nombres</label>
                                          <div class="form-group">
                                            <input id="nombre" type="text" class="form-control" name="nombre" placeholder="Ingrese nombre" value="{{ old('nombre') }}" required>
                                          </div>

                                          <label>Descripción</label>
                                          <div class="form-group">
                                            <input id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Ingrese descripción" value="{{ old('descripcion') }}" required>
                                          </div>

                                          <label>Integrar video</label>
                                          <div class="form-group">
                                            <input id="link" type="text" class="form-control" name="link" placeholder="(Opcional)" value="{{ old('link') }}">
                                          </div>

                                          <label>Añadir mp3 o mp4</label>
                                          <div class="form-group">
                                          <input id="archivo" type="file" class="form-control" name="archivo" value="{{ old('archivo') }}" accept=".mp3,.mp4">
                                          </div>
                                        
                                          <div class="d-flex justify-content-around">
                                          <button type="submit" class="btn-get-started">Registrar meme</button>
                                          </div>                
                              </form>
                          </div>
                      </div>
                    </div>
                </div>        
            </div>
            
            <div id="tab-3" class="tab-pane">
            <div class="row d-flex justify-content-around mt-6">
                  <div class="col-6">
                      <div class="card mb-4">
                          <div class="card-header pb-0">
                            <h6>Registro de Memes</h6>
                          </div>
                          <div class="d-flex justify-content-end px-5">
                                      <a href="{{ route('memes.lista')}}" class="btn-get-started">
                                          <i class="fas fa-chevron-left"></i>
                                          Regresar</a>
                          </div>
                          <div class="card-body px-5 pt-0 pb-2">
                              @if($errors->any())
                                      @foreach($errors->all() as $error)
                                      <div class="alert alert-danger" role="alert">
                                          {{ $error }}
                                      </div>
                                      @endforeach
                              @endif
                              <form action="{{ route('memes.store')}}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                          <!-- <label>Tipo</label> -->
                                          <div class="form-group">
                                          <input type="hidden" type="text" class="form-control" name="tipo" value="enlace">
                                          </div>
                                          <label>Imagen</label>
                                          <div class="form-group">
                                            <input type="file" class="form-control" name="imagen">
                                          </div>
                                          <label>Nombres</label>
                                          <div class="form-group">
                                            <input id="nombre" type="text" class="form-control" name="nombre" placeholder="Ingrese nombre" value="{{ old('nombre') }}" required>
                                          </div>

                                          <label>Descripción</label>
                                          <div class="form-group">
                                            <input id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Ingrese descripción" value="{{ old('descripcion') }}" required>
                                          </div>
                                          <label>Enlace</label>
                                          <div class="form-group">
                                            <input id="enlace" type="text" class="form-control" name="enlace" placeholder="Ingrese enlace" value="{{ old('enlace') }}" required>
                                          </div>
                                        
                                          <div class="d-flex justify-content-around">
                                          <button type="submit" class="btn-get-started">Registrar meme</button>
                                          </div>                
                              </form>
                          </div>
                      </div>
                    </div>
                </div>        
            </div>
         
          </div>
        </div>


    </div>
  </main>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3')}}"></script>
</body>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/index.js')}}"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection