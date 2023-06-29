<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juegos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class JuegosController extends Controller
{
    public function index()
    {   
        $recursos = Juegos::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
                ->paginate(8);
        $multimedias = Juegos::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Juegos::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Juegos::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $jue = Juegos::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $jue->pluck('likes_count', 'id'),
        ];

        return view('juegos.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $juegos = Juegos::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $jue = Juegos::withCount('likes')->get();
        $data = [
        'juegos' =>$juegos,
        'busqueda' =>$busqueda,
        'likes' => $jue->pluck('likes_count', 'id'),
        ];
        return view('juegos.lista', $data);
    }

    public function create()
    {   
        $juegos = Juegos::all();
        return view('juegos.create', compact('juegos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $juegos = new Juegos();
       $juegos->tipo = $request->tipo;
       $juegos->nombre = $request->nombre;
       $juegos->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
        $juegos->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->storeAs('public/lecciones', $archivo->getClientOriginalName());
        $juegos->recurso = $archivo->getClientOriginalName();
        }
        $juegos->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $juegos->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $juegos->archivo = null;

        }
        $juegos->enlace = $request->enlace;


       $juegos->save();
       

       $notificacion = 'El juego se ha registrado correctamente';
       return redirect()->route('juegos.lista')->with(compact('notificacion'));

    }


    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'juego_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('juegos.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('juegos.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->juego_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('juegos.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'juego_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('juegos.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('juego_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('juegos.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('juegos.index')->with('error', 'No se encontró el like correspondiente');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $juego = Juegos::findOrFail($id);
        $ruta_base = Storage::url('lecciones/');
        return view('juegos.show', compact('juego', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $juegos = Juegos::find($id);
        $data = [
            'juegos' =>$juegos,
        ];
        return view('juegos.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $juegos = Juegos::find($id);
        $juegos->nombre = $request->nombre;
        $juegos->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $juegos->imagen = $archivo->getClientOriginalName();
            }
            if ($request->hasFile('recurso')) {
                $validatedData = $request->validate([
                    'recurso' => 'sometimes|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx|max:10000',
                ]);
        
              // Eliminar el recurso existente si hay uno
                if (!is_null($juegos->recurso)) {
                    $rutaRecursoAnterior = storage_path('app/public/lecciones/') . $juegos->recurso;
                    if (File::exists($rutaRecursoAnterior)) {
                        File::delete($rutaRecursoAnterior);
                    }
                }
                $archivo = $request->file('recurso');
                $nombreArchivo = $archivo->getClientOriginalName();
                $archivo->storeAs('public/lecciones', $nombreArchivo);
                $juegos->recurso = $nombreArchivo;
            }
            $juegos->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
                $juegos->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $juegos->archivo = null;
    
            }
            $juegos->enlace = $request->enlace;

        $notificacion = 'El juego se ha actualizado correctamente';
        $juegos->save();      
        return redirect()->route('juegos.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $juegos = Juegos::find($id);        
        $juegos->delete();
        $notificacion = 'El juego se ha eliminado correctamente';
        return redirect()->route('juegos.lista')->with(compact('notificacion'));
    }
}
