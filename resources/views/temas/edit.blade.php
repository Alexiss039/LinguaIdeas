
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
                        <h3 class="mb-0">Editar tema</h3>
                    </div>
                    <div class="d-flex justify-content-end px-5">
                        <a href="{{ route('temas.lista')}}" class="btn-get-started">
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

                <form action="{{ route('temas.update',$temas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($temas->tipo == 'recurso')
                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $temas->nombre) }}" required>
                    </div>
            
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $temas->descripcion) }}" required>
                    </div>
                  
                    <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" class="form-control" name="imagen" value="{{ old('imagen', $temas->imagen) }}" >
                    </div>
                    <div class="form-group">
                        <label>Recurso</label>
                        <input type="file" class="form-control" name="recurso" value="{{ old('recurso', $temas->recurso) }}" >
                    </div> 
                    @endif                 
                    @if ($temas->tipo == 'multimedia')
                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $temas->nombre) }}" required>
                    </div>
            
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $temas->descripcion) }}" required>
                    </div>
                  
                    <div class="form-group">
                        <label>Video</label>
                        <input type="text" class="form-control" name="link" placeholder="(Opcional)" value="{{ old('link', $temas->link) }}" >
                    </div>                        
                    <div class="form-group">
                        <label>mp3 o mp4</label>
                        <input type="file" class="form-control" name="archivo" value="{{ old('archivo', $temas->archivo) }}" >
                    </div>
                    @endif 
                    @if ($temas->tipo == 'enlace')
                    <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" class="form-control" name="imagen" value="{{ old('imagen', $temas->imagen) }}" >
                    </div>
                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $temas->nombre) }}" required>
                    </div>
            
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $temas->descripcion) }}" required>
                    </div>
                  
                    <div class="form-group">
                        <label>Enlace</label>
                        <input type="text" class="form-control" name="enlace" placeholder="Ingrese enlace" value="{{ old('enlace', $temas->enlace) }}" >
                    </div> 
                    @endif 
                  
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
