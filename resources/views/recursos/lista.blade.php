@extends('Includes.panel.menu')

@section('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-start justify-content-between">
                    <div class="col">
                        <h3 class="mb-0">Recursos</h3>
                    </div>
                    <div class="col float-right">
                        <a href="{{ url('/recursos/create') }}" class="btn-get-started" style="position: absolute; top: 0; right: 10;">Añadir recursos</a>
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
                        @foreach($recursos as $recurso)
                        <tr>
                            <td>
                                {{ $recurso->id }}
                            </td>
                            <th>
                                {{ $recurso->tipo }}
                            </th>
                            <th>
                            {{ $likes[$recurso->id] }}
                            </th>
                            <th>
                            {{ substr($recurso->nombre, 0, 13) }}{{ strlen($recurso->nombre) > 13 ? "..." : "" }}
                            </th>
                            <td>
                            {{ substr($recurso->descripcion, 0, 13) }}{{ strlen($recurso->descripcion) > 13 ? "..." : "" }}
                            </td>
                            <td>
                            {{ !empty($recurso->imagen) ? substr($recurso->imagen, 0, 13) . (strlen($recurso->imagen) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($recurso->recurso) ? substr($recurso->recurso, 0, 13) . (strlen($recurso->recurso) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($recurso->link) ? substr($recurso->link, 0, 13) . (strlen($recurso->link) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($recurso->archivo) ? substr($recurso->archivo, 0, 13) . (strlen($recurso->archivo) > 13 ? '...' : '') : 'N/A' }}                               
                            </td>
                            <td>
                            {{ !empty($recurso->enlace) ? substr($recurso->enlace, 0, 13) . (strlen($recurso->enlace) > 13 ? '...' : '') : 'N/A' }}                               
                            </td>
                           
                            <td class="d-flex justify-content-center btn-group">
                                
                                <form action="{{ url('/recursos/'.$recurso->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE') 
                                    
                                    <a href="{{ url('/recursos/'.$recurso->id.'/edit') }}" class="btn-get-started">Editar</a>
                                    <button type="submit" class="btn-get-red">Eliminar</button>

                                </form>
                                
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                          <td colspan="4"> {{$recursos->appends(['busqueda'=>$busqueda])}}  </td>
                      </tr>
                  </tfoot>
                </table>
            </div>
        </div>
    
 </body>
@endsection
