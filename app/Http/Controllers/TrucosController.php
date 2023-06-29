<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trucos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TrucosController extends Controller
{
    public function index()
    {   
        $recursos = Trucos::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Trucos::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Trucos::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Trucos::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
                $truc = Trucos::withCount('likes')->get();
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        'likes' => $truc->pluck('likes_count', 'id'),
        ];

        return view('trucos.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $trucos = Trucos::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $truc = Trucos::withCount('likes')->get();
        $data = [
        'trucos' =>$trucos,
        'busqueda' =>$busqueda,
        'likes' => $truc->pluck('likes_count', 'id'),
        ];
        return view('trucos.lista', $data);
    }

    public function create()
    {   
        $trucos = Trucos::all();
        return view('trucos.create', compact('trucos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $trucos = new Trucos();
       $trucos->tipo = $request->tipo;
       $trucos->nombre = $request->nombre;
       $trucos->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
        $trucos->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->storeAs('public/lecciones', $archivo->getClientOriginalName());
        $trucos->recurso = $archivo->getClientOriginalName();
        }
        $trucos->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $trucos->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $trucos->archivo = null;

        }
        $trucos->enlace = $request->enlace;


       $trucos->save();
       

       $notificacion = 'El truco se ha registrado correctamente';
       return redirect()->route('trucos.lista')->with(compact('notificacion'));
    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'truco_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('trucos.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('trucos.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->truco_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('trucos.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'truco_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('trucos.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('truco_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('trucos.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('trucos.index')->with('error', 'No se encontró el like correspondiente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $truco = Trucos::findOrFail($id);
        $ruta_base = Storage::url('lecciones/');
        return view('trucos.show', compact('truco', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $trucos = Trucos::find($id);
        $data = [
            'trucos' =>$trucos,
        ];
        return view('trucos.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $trucos = Trucos::find($id);
        $trucos->nombre = $request->nombre;
        $trucos->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $trucos->imagen = $archivo->getClientOriginalName();
            }
            if ($request->hasFile('recurso')) {
                $validatedData = $request->validate([
                    'recurso' => 'sometimes|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx|max:10000',
                ]);
        
              // Eliminar el recurso existente si hay uno
                if (!is_null($trucos->recurso)) {
                    $rutaRecursoAnterior = storage_path('app/public/lecciones/') . $trucos->recurso;
                    if (File::exists($rutaRecursoAnterior)) {
                        File::delete($rutaRecursoAnterior);
                    }
                }
                $archivo = $request->file('recurso');
                $nombreArchivo = $archivo->getClientOriginalName();
                $archivo->storeAs('public/lecciones', $nombreArchivo);
                $trucos->recurso = $nombreArchivo;
            }
            $trucos->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
                $trucos->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $trucos->archivo = null;
    
            }
            $trucos->enlace = $request->enlace;

        $notificacion = 'El truco se ha actualizado correctamente';
        $trucos->save();      
        return redirect()->route('trucos.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $trucos = Trucos::find($id);        
        $trucos->delete();
        $notificacion = 'El truco se ha eliminado correctamente';
        return redirect()->route('trucos.lista')->with(compact('notificacion'));
    }
}
