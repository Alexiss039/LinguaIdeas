
@extends('Includes.panel.menu')

@section('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="row  justify-content-around mt-6">    

    <div class="col-6">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Editar Innovación y tendencia</h3>
                    </div>
                    <div class="d-flex justify-content-end px-5">
                        <a href="{{ route('innovacion.lista')}}" class="btn-get-started">
                            <i class="fas fa-chevron-left"></i>
                            Regresar</a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Por favor!!</strong> {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form action="{{ route('innovacion.update',$innovacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $innovacion->nombre) }}" required>
                    </div>
            
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $innovacion->descripcion) }}" required>
                    </div>
                    @if ($innovacion->tipo == 'recurso')
                    <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" class="form-control" name="imagen" value="{{ old('imagen', $innovacion->imagen) }}" >
                    </div>
                    @endif                 
                    <div class="form-group">
                        <label>Recurso</label>
                        <input type="file" class="form-control" name="recurso" value="{{ old('recurso', $innovacion->recurso) }}" >
                    </div> 
                    <div class="form-group">
                        <label>Video</label>
                        <input type="text" class="form-control" name="link" placeholder="(Opcional)" value="{{ old('link', $innovacion->link) }}" >
                    </div>                        
                    <div class="form-group">
                        <label>mp3 o mp4</label>
                        <input type="file" class="form-control" name="archivo" value="{{ old('archivo', $innovacion->archivo) }}" >
                    </div>
                    <div class="form-group">
                        <label>Enlace</label>
                        <input type="text" class="form-control" name="enlace" placeholder="Ingrese enlace" value="{{ old('enlace', $innovacion->enlace) }}" >
                    </div>  
                    <div class="d-flex justify-content-around">
                        <button type="submit" class="btn-get-started">Actualizar datos</button>
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</div>
 </body>
@endsection
