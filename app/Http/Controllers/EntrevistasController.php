<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrevistas;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EntrevistasController extends Controller
{
    public function index()
    {  
        $recursos = Entrevistas::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Entrevistas::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Entrevistas::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Entrevistas::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
        $entre = Entrevistas::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $entre->pluck('likes_count', 'id'),
        ];

        return view('entrevistas.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $entrevistas = Entrevistas::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);

        $entre = Entrevistas::withCount('likes')->get();
        $data = [
        'entrevistas' =>$entrevistas,
        'busqueda' =>$busqueda,
        'likes' => $entre->pluck('likes_count', 'id'),
        ];
        return view('entrevistas.lista', $data);
    }

    public function create()
    {   
        $entrevistas = Entrevistas::all();
        return view('entrevistas.create', compact('entrevistas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $entrevistas = new Entrevistas();
       $entrevistas->tipo = $request->tipo;
       $entrevistas->nombre = $request->nombre;
       $entrevistas->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
        $entrevistas->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->storeAs('public/lecciones', $archivo->getClientOriginalName());
        $entrevistas->recurso = $archivo->getClientOriginalName();
        }
        $entrevistas->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $entrevistas->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $entrevistas->archivo = null;

        }
        $entrevistas->enlace = $request->enlace;


       $entrevistas->save();
       

       $notificacion = 'La entrevista se ha registrado correctamente';
       return redirect()->route('entrevistas.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'entrevista_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('entrevistas.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('entrevistas.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->entrevista_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('entrevistas.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'entrevista_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('entrevistas.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('entrevista_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('entrevistas.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('entrevistas.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entrevista = Entrevistas::findOrFail($id);
        $ruta_base = Storage::url('lecciones/');
        return view('entrevistas.show', compact('entrevista', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $entrevistas = Entrevistas::find($id);
        $data = [
            'entrevistas' =>$entrevistas,
        ];
        return view('entrevistas.edit',$data);
    }
    
    public function update(Request $request, string $id)
    {   
        $entrevistas = Entrevistas::find($id);
        $entrevistas->nombre = $request->nombre;
        $entrevistas->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $entrevistas->imagen = $archivo->getClientOriginalName();
            }
            if ($request->hasFile('recurso')) {
                $validatedData = $request->validate([
                    'recurso' => 'sometimes|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx|max:10000',
                ]);
        
              // Eliminar el recurso existente si hay uno
                if (!is_null($entrevistas->recurso)) {
                    $rutaRecursoAnterior = storage_path('app/public/lecciones/') . $entrevistas->recurso;
                    if (File::exists($rutaRecursoAnterior)) {
                        File::delete($rutaRecursoAnterior);
                    }
                }
                $archivo = $request->file('recurso');
                $nombreArchivo = $archivo->getClientOriginalName();
                $archivo->storeAs('public/lecciones', $nombreArchivo);
                $entrevistas->recurso = $nombreArchivo;
            }
            $entrevistas->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
                $entrevistas->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $entrevistas->archivo = null;
    
            }
            $entrevistas->enlace = $request->enlace;

        $notificacion = 'La entrevista se ha actualizado correctamente';
        $entrevistas->save();      
        return redirect()->route('entrevistas.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $entrevistas = Entrevistas::find($id);        
        $entrevistas->delete();
        $notificacion = 'La entrevista se ha eliminado correctamente';
        return redirect()->route('entrevistas.lista')->with(compact('notificacion'));
    }
}
