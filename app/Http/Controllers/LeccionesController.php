<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecciones;
use App\Models\Like;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;



class LeccionesController extends Controller
{

    public function index()
    {   
        $recursos = Lecciones::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
                            ->paginate(8);
        $multimedias = Lecciones::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                            ->paginate(8);
        $enlaces = Lecciones::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                            ->paginate(8);
        $formularios = Lecciones::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                            ->paginate(8);

    // Obtener todas las lecciones con sus respectivos likes
    $lecciones = Lecciones::withCount('likes')->get();
        $data = [
        'lecciones' =>$lecciones,
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $lecciones->pluck('likes_count', 'id'),
        ];

        return view('lecciones.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $lecciones = Lecciones::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
            // Obtener todas las lecciones con sus respectivos likes
        $leccion = Lecciones::withCount('likes')->get();
        $data = [
        'lecciones' =>$lecciones,
        'busqueda' =>$busqueda,
        'likes' => $leccion->pluck('likes_count', 'id'),
        ];
        return view('lecciones.lista', $data);
    }
    
    public function create()
    {   
        $lecciones = Lecciones::all();
        return view('lecciones.create', compact('lecciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

       $lecciones = new Lecciones();
       $lecciones->tipo = $request->tipo;
       $lecciones->nombre = $request->nombre;
       $lecciones->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $lecciones->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $validatedData = $request->validate([
            'recurso' => 'sometimes|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $lecciones->recurso = $archivo->getClientOriginalName();
        }
        $lecciones->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $lecciones->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $lecciones->archivo = null;

        }
        $lecciones->enlace = $request->enlace;


       $lecciones->save();


       

       $notificacion = 'La lección se ha registrado correctamente';
       return redirect()->route('lecciones.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'leccion_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('lecciones.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('lecciones.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->leccion_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('lecciones.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'leccion_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('lecciones.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('leccion_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('lecciones.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('lecciones.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    { 
       $leccion = Lecciones::findOrFail($id);
        $ruta_base = 'lecciones/';
       return view('lecciones.show', compact('leccion', 'ruta_base'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lecciones = Lecciones::find($id);
        $data = [
            'lecciones' =>$lecciones,
        ];
        return view('lecciones.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lecciones = Lecciones::find($id);
        $lecciones->nombre = $request->nombre;
        $lecciones->descripcion = $request->descripcion;
    
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $archivo->move(public_path() . '/recursos/', $archivo->getClientOriginalName());
            $lecciones->imagen = $archivo->getClientOriginalName();
        }
    
        if ($request->hasFile('recurso')) {
            $archivo = $request->file('recurso');
            $archivo->move(public_path() . '/lecciones/', $archivo->getClientOriginalName());
            $lecciones->recurso = $archivo->getClientOriginalName();
        }
    
        $lecciones->setVideoEmbedAttribute($request->input('link'));
    
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
    
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                // Almacenar el archivo en el servidor
                $archivo->move(public_path() . '/recursos/', $archivo->getClientOriginalName());
                $lecciones->archivo = $archivo->getClientOriginalName();
            }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $lecciones->archivo = null;
        }
    
        $lecciones->enlace = $request->enlace;
    
        $notificacion = 'La lección se ha actualizado correctamente';
        $lecciones->save();
    
        // Agregar los encabezados de respuesta para evitar la caché
        return response()
            ->redirectToRoute('lecciones.lista')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Cache-Control', 'post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->with(compact('notificacion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lecciones = Lecciones::find($id);        
        $lecciones->delete();
        $notificacion = 'La lección se ha eliminado correctamente';
        return redirect()->route('lecciones.lista')->with(compact('notificacion'));
    }

}
