<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicios;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
class EjerciciosController extends Controller
{
    public function index()
    {   
        $recursos = Ejercicios::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
                            ->paginate(8);
        $multimedias = Ejercicios::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                            ->paginate(8);
        $enlaces = Ejercicios::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                            ->paginate(8);
        $formularios = Ejercicios::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                            ->paginate(8);

    $ejerci = Ejercicios::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $ejerci->pluck('likes_count', 'id'),
        ];

        return view('ejercicios.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $ejercicios = Ejercicios::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);

        $ejerci = Ejercicios::withCount('likes')->get();
        $data = [
        'ejercicios' =>$ejercicios,
        'busqueda' =>$busqueda,
        'likes' => $ejerci->pluck('likes_count', 'id'),
        ];
        return view('ejercicios.lista', $data);
    }

    public function create()
    {   
        $ejercicios = Ejercicios::all();
        return view('ejercicios.create', compact('ejercicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $ejercicios = new Ejercicios();
       $ejercicios->tipo = $request->tipo;
       $ejercicios->nombre = $request->nombre;
       $ejercicios->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $ejercicios->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $ejercicios->recurso = $archivo->getClientOriginalName();
        }
        $ejercicios->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $ejercicios->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $ejercicios->archivo = null;

        }
        $ejercicios->enlace = $request->enlace;


       $ejercicios->save();
       

       $notificacion = 'El ejercicio se ha registrado correctamente';
       return redirect()->route('ejercicios.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'ejercicio_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('ejercicios.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('ejercicios.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->ejercicio_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('ejercicios.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'ejercicio_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('ejercicios.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('ejercicio_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('ejercicios.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('ejercicios.index')->with('error', 'No se encontró el like correspondiente');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ejercicio = Ejercicios::findOrFail($id);
         $ruta_base = 'lecciones/';
        return view('ejercicios.show', compact('ejercicio', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $ejercicios = Ejercicios::find($id);
        $data = [
            'ejercicios' =>$ejercicios,
        ];
        return view('ejercicios.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $ejercicios = Ejercicios::find($id);
        $ejercicios->nombre = $request->nombre;
        $ejercicios->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $ejercicios->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $ejercicios->recurso = $archivo->getClientOriginalName();
            }
            $ejercicios->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $ejercicios->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $ejercicios->archivo = null;
    
            }
            $ejercicios->enlace = $request->enlace;

        $notificacion = 'El ejercicio se ha actualizado correctamente';
        $ejercicios->save();      
        return redirect()->route('ejercicios.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $ejercicios = Ejercicios::find($id);        
        $ejercicios->delete();
        $notificacion = 'El ejercicio se ha eliminado correctamente';
        return redirect()->route('ejercicios.lista')->with(compact('notificacion'));
    }
}
