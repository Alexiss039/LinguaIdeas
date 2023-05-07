<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gramatica;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
class GramaticaController extends Controller
{
    public function index()
    {   
        $recursos = Gramatica::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Gramatica::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Gramatica::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Gramatica::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $gram = Gramatica::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $gram->pluck('likes_count', 'id'),
        ];

        return view('gramatica.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $gramatica = Gramatica::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $gram = Gramatica::withCount('likes')->get();
        $data = [
        'gramatica' =>$gramatica,
        'busqueda' =>$busqueda,
        'likes' => $gram->pluck('likes_count', 'id'),
        ];
        return view('gramatica.lista', $data);
    }

    public function create()
    {   
        $gramaticas = Gramatica::all();
        return view('gramatica.create', compact('gramaticas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $gramaticas = new Gramatica();
       $gramaticas->tipo = $request->tipo;
       $gramaticas->nombre = $request->nombre;
       $gramaticas->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $gramaticas->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $gramaticas->recurso = $archivo->getClientOriginalName();
        }
        $gramaticas->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $gramaticas->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $gramaticas->archivo = null;

        }
        $gramaticas->enlace = $request->enlace;


       $gramaticas->save();
       

       $notificacion = 'La gramatica se ha registrado correctamente';
       return redirect()->route('gramatica.lista')->with(compact('notificacion'));
    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'gramatica_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('gramatica.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('gramatica.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->gramatica_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('gramatica.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'gramatica_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('gramatica.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('gramatica_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('gramatica.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('gramatica.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gramatica = Gramatica::findOrFail($id);
         $ruta_base = 'lecciones/'; 'gramatica/';
        return view('gramatica.show', compact('gramatica', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $gramatica = Gramatica::find($id);
        $data = [
            'gramatica' =>$gramatica,
        ];
        return view('gramatica.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $gramatica = Gramatica::find($id);
        $gramatica->nombre = $request->nombre;
        $gramatica->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $gramatica->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $gramatica->recurso = $archivo->getClientOriginalName();
            }
            $gramatica->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $gramatica->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $gramatica->archivo = null;
    
            }
            $gramatica->enlace = $request->enlace;

        $notificacion = 'La gramatica se ha actualizado correctamente';
        $gramatica->save();      
        return redirect()->route('gramatica.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $gramaticas = Gramatica::find($id);        
        $gramaticas->delete();
        $notificacion = 'La gramatica se ha eliminado correctamente';
        return redirect()->route('gramatica.lista')->with(compact('notificacion'));
    }
}
