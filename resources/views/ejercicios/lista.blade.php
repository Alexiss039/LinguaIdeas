@extends('Includes.panel.menu')

@section('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-start justify-content-between">
                    <div class="col">
                        <h3 class="mb-0">Ejercicios</h3>
                    </div>
                    <div class="col float-right">
                        <a href="{{ url('/ejercicios/create') }}" class="btn-get-started" style="position: absolute; top: 0; right: 10;">Añadir ejercicio</a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if(session('notificacion'))
                    <div class="alert alert-success" role="alert">
                         {{ session('notificacion') }}
                    </div>
                @endif
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <thead class="thead">
                        <tr>
                        <th class="text-capitalize font-weight-bolder">Id</th>
                        <th class="text-capitalize font-weight-bolder">Tipo</th>
                        <th class="text-capitalize font-weight-bolder">Nombre</th>
                        <th class="text-capitalize font-weight-bolder">Descripción</th>
                        <th class="text-capitalize font-weight-bolder">Imagen</th>   
                        <th class="text-capitalize font-weight-bolder">Recurso</th>
                        <th class="text-capitalize font-weight-bolder">Video</th>
                        <th class="text-capitalize font-weight-bolder">Archivo</th>  
                        <th class="text-capitalize font-weight-bolder">Enlace</th>    
                        <th class="text-center text-capitalize font-weight-bolder">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ejercicios as $ejercicio)
                        <tr>
                            <td>
                                {{ $ejercicio->id }}
                            </td>
                            <th>
                                {{ $ejercicio->tipo }}
                            </th>
                            <th>
                                {{ $ejercicio->nombre }}
                            </th>
                            <td>
                                {{ $ejercicio->descripcion }}
                            </td>
                            <td>
                            {{ !empty($ejercicio->imagen) ? $ejercicio->imagen : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($ejercicio->recurso) ? $ejercicio->recurso : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($ejercicio->link) ? $ejercicio->link : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($ejercicio->archivo) ? $ejercicio->archivo : 'N/A' }}                               
                            </td>
                            <td>
                            {{ !empty($ejercicio->enlace) ? $ejercicio->enlace : 'N/A' }}                               
                            </td>
                           
                            <td class="d-flex justify-content-center btn-group">
                                
                                <form action="{{ url('/ejercicios/'.$ejercicio->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE') 
                                    
                                    <a href="{{ url('/ejercicios/'.$ejercicio->id.'/edit') }}" class="btn-get-started">Editar</a>
                                    <button type="submit" class="btn-get-red">Eliminar</button>

                                </form>
                                
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                          <td colspan="4"> {{$ejercicios->appends(['busqueda'=>$busqueda])}}  </td>
                      </tr>
                  </tfoot>
                </table>
            </div>
        </div>
    
 </body>
@endsection
