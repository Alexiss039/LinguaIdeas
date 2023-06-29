<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pronunciacion;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PronunciacionController extends Controller
{
    public function index()
    {   
        $recursos = Pronunciacion::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Pronunciacion::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Pronunciacion::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Pronunciacion::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $pron = Pronunciacion::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $pron->pluck('likes_count', 'id'),
        ];

        return view('pronunciacion.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $pronunciacion = Pronunciacion::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $pron = Pronunciacion::withCount('likes')->get();
        $data = [
        'pronunciacion' =>$pronunciacion,
        'busqueda' =>$busqueda,
        'likes' => $pron->pluck('likes_count', 'id'),
        ];
        return view('pronunciacion.lista', $data);
    }


    public function create()
    {   
        $pronunciacion = Pronunciacion::all();
        return view('pronunciacion.create', compact('pronunciacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $pronunciacion = new Pronunciacion();
       $pronunciacion->tipo = $request->tipo;
       $pronunciacion->nombre = $request->nombre;
       $pronunciacion->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
        $pronunciacion->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->storeAs('public/lecciones', $archivo->getClientOriginalName());
        $pronunciacion->recurso = $archivo->getClientOriginalName();
        }
        $pronunciacion->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $pronunciacion->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $pronunciacion->archivo = null;

        }
        $pronunciacion->enlace = $request->enlace;


       $pronunciacion->save();
       

       $notificacion = 'La pronunciacion se ha registrado correctamente';
       return redirect()->route('pronunciacion.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'pronunciacion_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('pronunciacion.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('pronunciacion.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->pronunciacion_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('pronunciacion.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'pronunciacion_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('pronunciacion.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('pronunciacion_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('pronunciacion.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('pronunciacion.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pronunciacion = Pronunciacion::findOrFail($id);
        $ruta_base = Storage::url('lecciones/');
        return view('pronunciacion.show', compact('pronunciacion', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $pronunciacion = Pronunciacion::find($id);
        $data = [
            'pronunciacion' =>$pronunciacion,
        ];
        return view('pronunciacion.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $pronunciacion = Pronunciacion::find($id);
        $pronunciacion->nombre = $request->nombre;
        $pronunciacion->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $pronunciacion->imagen = $archivo->getClientOriginalName();
            }
            if ($request->hasFile('recurso')) {
                $validatedData = $request->validate([
                    'recurso' => 'sometimes|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx|max:10000',
                ]);
        
              // Eliminar el recurso existente si hay uno
                if (!is_null($pronunciacion->recurso)) {
                    $rutaRecursoAnterior = storage_path('app/public/lecciones/') . $pronunciacion->recurso;
                    if (File::exists($rutaRecursoAnterior)) {
                        File::delete($rutaRecursoAnterior);
                    }
                }
                $archivo = $request->file('recurso');
                $nombreArchivo = $archivo->getClientOriginalName();
                $archivo->storeAs('public/lecciones', $nombreArchivo);
                $pronunciacion->recurso = $nombreArchivo;
            }
            $pronunciacion->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
                $pronunciacion->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $pronunciacion->archivo = null;
    
            }
            $pronunciacion->enlace = $request->enlace;

        $notificacion = 'La pronunciacion se ha actualizado correctamente';
        $pronunciacion->save();      
        return redirect()->route('pronunciacion.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $pronunciacion = Pronunciacion::find($id);        
        $pronunciacion->delete();
        $notificacion = 'La pronunciacion se ha eliminado correctamente';
        return redirect()->route('pronunciacion.lista')->with(compact('notificacion'));
    }
}
