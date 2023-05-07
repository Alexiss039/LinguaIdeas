<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Innovacion;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
class InnovacionController extends Controller
{
    public function index()
    {
        $recursos = Innovacion::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Innovacion::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Innovacion::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Innovacion::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $innov = Innovacion::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $innov->pluck('likes_count', 'id'),
        ];

        return view('innovacion.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $innovacion = Innovacion::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $innov = Innovacion::withCount('likes')->get();
        $data = [
        'innovacion' =>$innovacion,
        'busqueda' =>$busqueda,
        'likes' => $innov->pluck('likes_count', 'id'),
        ];
        return view('innovacion.lista', $data);
    }

    public function create()
    {   
        $innovacion = Innovacion::all();
        return view('innovacion.create', compact('innovacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $innovacion = new Innovacion();
       $innovacion->tipo = $request->tipo;
       $innovacion->nombre = $request->nombre;
       $innovacion->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $innovacion->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $innovacion->recurso = $archivo->getClientOriginalName();
        }
        $innovacion->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $innovacion->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $innovacion->archivo = null;

        }
        $innovacion->enlace = $request->enlace;


       $innovacion->save();
       

       $notificacion = 'La innovacion se ha registrado correctamente';
       return redirect()->route('innovacion.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'innovacion_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('innovacion.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('innovacion.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->innovacion_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('innovacion.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'innovacion_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('innovacion.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('innovacion_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('innovacion.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('innovacion.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $innovacion = Innovacion::findOrFail($id);
         $ruta_base = 'lecciones/'; 'innovacion/';
        return view('innovacion.show', compact('innovacion', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $innovacion = Innovacion::find($id);
        $data = [
            'innovacion' =>$innovacion,
        ];
        return view('innovacion.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $innovacion = Innovacion::find($id);
        $innovacion->nombre = $request->nombre;
        $innovacion->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $innovacion->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $innovacion->recurso = $archivo->getClientOriginalName();
            }
            $innovacion->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $innovacion->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $innovacion->archivo = null;
    
            }
            $innovacion->enlace = $request->enlace;

        $notificacion = 'La innovacion se ha actualizado correctamente';
        $innovacion->save();      
        return redirect()->route('innovacion.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $innovacion = Innovacion::find($id);        
        $innovacion->delete();
        $notificacion = 'La innovación se ha eliminado correctamente';
        return redirect()->route('innovacion.lista')->with(compact('notificacion'));
    }
}
