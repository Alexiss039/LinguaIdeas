@extends('Includes.panel.menu')

@section('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-start justify-content-between">
                    <div class="col">
                        <h3 class="mb-0">Gramática</h3>
                    </div>
                    <div class="col float-right">
                        <a href="{{ url('/gramatica/create') }}" class="btn-get-started" style="position: absolute; top: 0; right: 10;">Añadir gramática</a>
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
                        <th class="text-capitalize font-weight-bolder">Likes</th>
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
                        @foreach($gramatica as $grama)
                        <tr>
                            <td>
                                {{ $grama->id }}
                            </td>
                            <th>
                                {{ $grama->tipo }}
                            </th>
                            <th>
                            {{ $likes[$grama->id] }}
                            </th>
                            <th>
                            {{ substr($grama->nombre, 0, 13) }}{{ strlen($grama->nombre) > 13 ? "..." : "" }}
                            </th>
                            <td>
                            {{ substr($grama->descripcion, 0, 13) }}{{ strlen($grama->descripcion) > 13 ? "..." : "" }}
                            </td>
                            <td>
                            {{ !empty($grama->imagen) ? substr($grama->imagen, 0, 13) . (strlen($grama->imagen) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($grama->recurso) ? substr($grama->recurso, 0, 13) . (strlen($grama->recurso) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($grama->link) ? substr($grama->link, 0, 13) . (strlen($grama->link) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($grama->archivo) ? substr($grama->archivo, 0, 13) . (strlen($grama->archivo) > 13 ? '...' : '') : 'N/A' }}                               
                            </td>
                            <td>
                            {{ !empty($grama->enlace) ? substr($grama->enlace, 0, 13) . (strlen($grama->enlace) > 13 ? '...' : '') : 'N/A' }}                               
                            </td>
                           
                            <td class="d-flex justify-content-center btn-group">
                                
                                <form action="{{ url('/gramatica/'.$grama->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE') 
                                    
                                    <a href="{{ url('/gramatica/'.$grama->id.'/edit') }}" class="btn-get-started">Editar</a>
                                    <button type="submit" class="btn-get-red">Eliminar</button>

                                </form>
                                
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                          <td colspan="4"> {{$gramatica->appends(['busqueda'=>$busqueda])}}  </td>
                      </tr>
                  </tfoot>
                </table>
            </div>
        </div>
    
 </body>
@endsection
