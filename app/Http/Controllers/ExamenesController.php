<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examenes;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ExamenesController extends Controller
{
    public function index()
    {   
        $examenes = DB::table('examenes')->orderByDesc('id')->paginate(8);
        $exam = Examenes::withCount('likes')->get();
        return view('examenes.index', compact('examenes','exam'));
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $examenes = Examenes::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $exam = Examenes::withCount('likes')->get();
        $data = [
        'examenes' =>$examenes,
        'busqueda' =>$busqueda,
        'likes' => $exam->pluck('likes_count', 'id'),
        ];
        return view('examenes.lista', $data);
    }

    public function create()
    {   
        $examenes = Examenes::all();
        return view('examenes.create', compact('examenes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

       $examenes = new Examenes();
       $examenes->nombre = $request->nombre;
       $examenes->descripcion = $request->descripcion;
       $examenes->enlace = $request->enlace;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
        $examenes->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->storeAs('public/lecciones', $archivo->getClientOriginalName());
        $examenes->recurso = $archivo->getClientOriginalName();
        }    
       $examenes->save();
       

       $notificacion = 'El examen se ha registrado correctamente';
       return redirect()->route('examenes.lista')->with(compact('notificacion'));

    }

    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'examen_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('examenes.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('examenes.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->examen_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('examenes.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'examen_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('examenes.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('examen_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('examenes.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('examenes.index')->with('error', 'No se encontró el like correspondiente');
    }

    public function show(string $id)
    {
        $examen = Examenes::findOrFail($id);
        $ruta_base = Storage::url('lecciones/');
        return view('examenes.show', compact('examen', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $examenes = Examenes::find($id);
        $data = [
            'examenes' =>$examenes,
        ];
        return view('examenes.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $examenes = Examenes::find($id);
        $examenes->nombre = $request->nombre;
        $examenes->descripcion = $request->descripcion;
        $examenes->enlace = $request->enlace;  
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->storeAs('public/recursos', $archivo->getClientOriginalName());
            $examenes->imagen = $archivo->getClientOriginalName();
            } 
        if ($request->hasFile('recurso')) {
            $validatedData = $request->validate([
                'recurso' => 'sometimes|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx|max:10000',
            ]);
    
          // Eliminar el recurso existente si hay uno
            if (!is_null($examenes->recurso)) {
                $rutaRecursoAnterior = storage_path('app/public/lecciones/') . $examenes->recurso;
                if (File::exists($rutaRecursoAnterior)) {
                    File::delete($rutaRecursoAnterior);
                }
            }
            $archivo = $request->file('recurso');
            $nombreArchivo = $archivo->getClientOriginalName();
            $archivo->storeAs('public/lecciones', $nombreArchivo);
            $examenes->recurso = $nombreArchivo;
        }

        $notificacion = 'El examen se ha actualizado correctamente';
        $examenes->save();      
        return redirect()->route('examenes.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $examenes = Examenes::find($id);        
        $examenes->delete();
        $notificacion = 'El examen se ha eliminado correctamente';
        return redirect()->route('examenes.lista')->with(compact('notificacion'));
    }
}
