@extends('Includes.panel.menu')

@section('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-start justify-content-between">
                    <div class="col">
                        <h3 class="mb-0">Temas</h3>
                    </div>
                    <div class="col float-right">
                        <a href="{{ url('/temas/create') }}" class="btn-get-started" style="position: absolute; top: 0; right: 10;">Añadir temas</a>
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
                        @foreach($temas as $tema)
                        <tr>
                            <td>
                                {{ $tema->id }}
                            </td>
                            <th>
                                {{ $tema->tipo }}
                            </th>
                            <th>
                            {{ $likes[$tema->id] }}
                            </th>
                            <th>
                            {{ substr($tema->nombre, 0, 13) }}{{ strlen($tema->nombre) > 13 ? "..." : "" }}
                            </th>
                            <td>
                            {{ substr($tema->descripcion, 0, 13) }}{{ strlen($tema->descripcion) > 13 ? "..." : "" }}
                            </td>
                            <td>
                            {{ !empty($tema->imagen) ? substr($tema->imagen, 0, 13) . (strlen($tema->imagen) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($tema->recurso) ? substr($tema->recurso, 0, 13) . (strlen($tema->recurso) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($tema->link) ? substr($tema->link, 0, 13) . (strlen($tema->link) > 13 ? '...' : '') : 'N/A' }}
                            </td>
                            <td>
                            {{ !empty($tema->archivo) ? substr($tema->archivo, 0, 13) . (strlen($tema->archivo) > 13 ? '...' : '') : 'N/A' }}                               
                            </td>
                            <td>
                            {{ !empty($tema->enlace) ? substr($tema->enlace, 0, 13) . (strlen($tema->enlace) > 13 ? '...' : '') : 'N/A' }}                               
                            </td>
                           
                            <td class="d-flex justify-content-center btn-group">
                                
                                <form action="{{ url('/temas/'.$tema->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE') 
                                    
                                    <a href="{{ url('/temas/'.$tema->id.'/edit') }}" class="btn-get-started">Editar</a>
                                    <button type="submit" class="btn-get-red">Eliminar</button>

                                </form>
                                
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                          <td colspan="4"> {{$temas->appends(['busqueda'=>$busqueda])}}  </td>
                      </tr>
                  </tfoot>
                </table>
            </div>
        </div>
    
 </body>
@endsection
