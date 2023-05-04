
@extends('includes.panel.menu')  

@section('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
    
      <div class="container-fluid py-4">
      <div class="row d-flex justify-content-around mt-6">
      <div class="col-6">
                      <div class="card mb-4">
                          <div class="card-header pb-0">
                            <h6>Registro de Examenes</h6>
                          </div>
                          <div class="d-flex justify-content-end px-5">
                                      <a href="{{ route('examenes.lista')}}" class="btn-get-started">
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
                              <form action="{{ route('examenes.store')}}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                    
                                          <label>Nombre</label>
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
                                          <button type="submit" class="btn-get-started">Registrar examen</button>
                                          </div>                
                              </form>
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