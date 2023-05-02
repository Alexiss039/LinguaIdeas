
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
              <h6>Crear examen</h6>
            </div>
            <div class="d-flex justify-content-end px-5">
               <a class="btn bg-gradient-dark mb-0" href="{{ route('examenes.index')}}"><i class="fas fa-plus"></i>Regresar</a>
            </div>
            <div class="card-body px-5 pt-0 pb-2">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                     <div class="alert alert-danger" role="alert">
                        {{ $error }}
                     </div>
                    @endforeach
                @endif
             <form action="{{ route('examenes.store')}}" method="POST">
                @csrf
             
                    <label>Nombres</label>
                    <div class="form-group">
                      <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                    </div>

                    <label>Descripción</label>
                    <div class="form-group">
                      <input id="descripcion" type="text" class="form-control" name="descripcion" value="{{ old('descripcion') }}" required>
                    </div>
                  
                    <div class="d-flex justify-content-around">
                    <button type="submit" class="btn btn-sm btn-primary">Crear examen</button>
                    </div>                
             </form>
            </div>
          </div>
        </div>
      </div>
  
        
      
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="{{ asset('js/core/popper.min.js')}}"></script>
  <script src="{{ asset('js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{ asset('js/plugins/chartjs.min.js')}}"></script>
     
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
  <script src="{{ asset('js/soft-ui-dashboard.min.js?v=1.0.3')}}"></script>
</body>
@endsection

@section('scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection