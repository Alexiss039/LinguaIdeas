
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
                            <h6>Registro de Gramática</h6>
                          </div>
                          <div class="d-flex justify-content-end px-5">
                                      <a href="{{ route('gramatica.lista')}}" class="btn-get-started">
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
                              <form action="{{ route('gramatica.store')}}" method="POST" enctype="multipart/form-data">
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
                                            <input type="file" class="form-control" name="recurso" required>
                                          </div>
                                        
                                          <div class="d-flex justify-content-around">
                                          <button type="submit" class="btn-get-started">Registrar gramática</button>
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
                            <h6>Registro de Gramática</h6>
                          </div>
                          <div class="d-flex justify-content-end px-5">
                                      <a href="{{ route('gramatica.lista')}}" class="btn-get-started">
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
                              <form action="{{ route('gramatica.store')}}" method="POST" enctype="multipart/form-data">
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
                                          <button type="submit" class="btn-get-started">Registrar gramática</button>
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
                            <h6>Registro de Gramática</h6>
                          </div>
                          <div class="d-flex justify-content-end px-5">
                                      <a href="{{ route('gramatica.lista')}}" class="btn-get-started">
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
                              <form action="{{ route('gramatica.store')}}" method="POST" enctype="multipart/form-data">
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
                                          <button type="submit" class="btn-get-started">Registrar gramática</button>
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
 </body>
@endsection