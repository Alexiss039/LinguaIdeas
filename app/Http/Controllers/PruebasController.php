<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pruebas;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
class PruebasController extends Controller
{
    public function index()
    {   
        $recursos = Pruebas::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Pruebas::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Pruebas::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Pruebas::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $prue = Pruebas::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $prue->pluck('likes_count', 'id'),
        ];

        return view('pruebas.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $pruebas = Pruebas::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $prue = Pruebas::withCount('likes')->get();
        $data = [
        'pruebas' =>$pruebas,
        'busqueda' =>$busqueda,
        'likes' => $prue->pluck('likes_count', 'id'),
        ];
        return view('pruebas.lista', $data);
    }

    public function create()
    {   
        $pruebas = Pruebas::all();
        return view('pruebas.create', compact('pruebas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $pruebas = new Pruebas();
       $pruebas->tipo = $request->tipo;
       $pruebas->nombre = $request->nombre;
       $pruebas->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $pruebas->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $pruebas->recurso = $archivo->getClientOriginalName();
        }
        $pruebas->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $pruebas->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $pruebas->archivo = null;

        }
        $pruebas->enlace = $request->enlace;


       $pruebas->save();
       

       $notificacion = 'La prueba se ha registrado correctamente';
       return redirect()->route('pruebas.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'prueba_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('pruebas.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('pruebas.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->prueba_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('pruebas.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'prueba_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('pruebas.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('prueba_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('pruebas.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('pruebas.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prueba = Pruebas::findOrFail($id);
         $ruta_base = 'lecciones/'; 'pruebas/';
        return view('pruebas.show', compact('prueba', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $pruebas = Pruebas::find($id);
        $data = [
            'pruebas' =>$pruebas,
        ];
        return view('pruebas.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $pruebas = Pruebas::find($id);
        $pruebas->nombre = $request->nombre;
        $pruebas->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $pruebas->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $pruebas->recurso = $archivo->getClientOriginalName();
            }
            $pruebas->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $pruebas->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $pruebas->archivo = null;
    
            }
            $pruebas->enlace = $request->enlace;

        $notificacion = 'La prueba se ha actualizado correctamente';
        $pruebas->save();      
        return redirect()->route('pruebas.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $pruebas = Pruebas::find($id);        
        $pruebas->delete();
        $notificacion = 'La prueba se ha eliminado correctamente';
        return redirect()->route('pruebas.lista')->with(compact('notificacion'));
    }
}
