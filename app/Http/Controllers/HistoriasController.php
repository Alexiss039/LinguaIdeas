<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historias;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HistoriasController extends Controller
{
    public function index()
    {   
        $recursos = Historias::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Historias::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Historias::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Historias::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $hist = Historias::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $hist->pluck('likes_count', 'id'),
        ];

        return view('historias.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $historias = Historias::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $hist = Historias::withCount('likes')->get();
        $data = [
        'historias' =>$historias,
        'busqueda' =>$busqueda,
        'likes' => $hist->pluck('likes_count', 'id'),
        ];
        return view('historias.lista', $data);
    }

    public function create()
    {   
        $historias = Historias::all();
        return view('historias.create', compact('historias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $historias = new Historias();
       $historias->tipo = $request->tipo;
       $historias->nombre = $request->nombre;
       $historias->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
        $historias->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->storeAs('public/lecciones', $archivo->getClientOriginalName());
        $historias->recurso = $archivo->getClientOriginalName();
        }
        $historias->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $historias->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $historias->archivo = null;

        }
        $historias->enlace = $request->enlace;


       $historias->save();
       

       $notificacion = 'La historia se ha registrado correctamente';
       return redirect()->route('historias.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'historia_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('historias.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('historias.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->historia_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('historias.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'historia_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('historias.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('historia_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('historias.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('historias.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $historia = Historias::findOrFail($id);
        $ruta_base = Storage::url('lecciones/');
        return view('historias.show', compact('historia', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $historias = Historias::find($id);
        $data = [
            'historias' =>$historias,
        ];
        return view('historias.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $historias = Historias::find($id);
        $historias->nombre = $request->nombre;
        $historias->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $historias->imagen = $archivo->getClientOriginalName();
            }
            if ($request->hasFile('recurso')) {
                $validatedData = $request->validate([
                    'recurso' => 'sometimes|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx|max:10000',
                ]);
        
              // Eliminar el recurso existente si hay uno
                if (!is_null($historias->recurso)) {
                    $rutaRecursoAnterior = storage_path('app/public/lecciones/') . $historias->recurso;
                    if (File::exists($rutaRecursoAnterior)) {
                        File::delete($rutaRecursoAnterior);
                    }
                }
                $archivo = $request->file('recurso');
                $nombreArchivo = $archivo->getClientOriginalName();
                $archivo->storeAs('public/lecciones', $nombreArchivo);
                $historias->recurso = $nombreArchivo;
            }
            $historias->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
                $historias->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $historias->archivo = null;
    
            }
            $historias->enlace = $request->enlace;

        $notificacion = 'La historia se ha actualizado correctamente';
        $historias->save();      
        return redirect()->route('historias.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $historias = Historias::find($id);        
        $historias->delete();
        $notificacion = 'La historia se ha eliminado correctamente';
        return redirect()->route('historias.lista')->with(compact('notificacion'));
    }
}
