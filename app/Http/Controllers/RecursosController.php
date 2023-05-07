<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recursos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
class RecursosController extends Controller
{
    public function index()
    {   
        $recursos = Recursos::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Recursos::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Recursos::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Recursos::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $recu = Recursos::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $recu->pluck('likes_count', 'id'),
        ];

        return view('recursos.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $recursos = Recursos::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $recu = Recursos::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'busqueda' =>$busqueda,
        'likes' => $recu->pluck('likes_count', 'id'),
        ];
        return view('recursos.lista', $data);
    }

    public function create()
    {   
        $recursos = Recursos::all();
        return view('recursos.create', compact('recursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $recursos = new Recursos();
       $recursos->tipo = $request->tipo;
       $recursos->nombre = $request->nombre;
       $recursos->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $recursos->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $recursos->recurso = $archivo->getClientOriginalName();
        }
        $recursos->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $recursos->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $recursos->archivo = null;

        }
        $recursos->enlace = $request->enlace;


       $recursos->save();
       

       $notificacion = 'Los recursos se ha registrado correctamente';
       return redirect()->route('recursos.lista')->with(compact('notificacion'));

    }


    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'recurso_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('recursos.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('recursos.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->recurso_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('recursos.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'recurso_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('recursos.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('recurso_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('recursos.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('recursos.index')->with('error', 'No se encontró el like correspondiente');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recurso = Recursos::findOrFail($id);
         $ruta_base = 'lecciones/'; 'recursos/';
        return view('recursos.show', compact('recurso', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $recursos = Recursos::find($id);
        $data = [
            'recursos' =>$recursos,
        ];
        return view('recursos.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $recursos = Recursos::find($id);
        $recursos->nombre = $request->nombre;
        $recursos->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $recursos->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $recursos->recurso = $archivo->getClientOriginalName();
            }
            $recursos->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $recursos->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $recursos->archivo = null;
    
            }
            $recursos->enlace = $request->enlace;

        $notificacion = 'El recurso se ha actualizado correctamente';
        $recursos->save();      
        return redirect()->route('recursos.lista')->with(compact('notificacion'));
    }


    public function destroy(string $id)
    {
        $recursos = Recursos::find($id);        
        $recursos->delete();
        $notificacion = 'El recurso se ha eliminado correctamente';
        return redirect()->route('recursos.lista')->with(compact('notificacion'));
    }
}
