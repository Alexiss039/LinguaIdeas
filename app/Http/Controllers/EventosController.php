<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class EventosController extends Controller
{
    public function index()
    {   
        $recursos = Eventos::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Eventos::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Eventos::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Eventos::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('eventos.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $eventos = Eventos::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'eventos' =>$eventos,
        'busqueda' =>$busqueda,
        ];
        return view('eventos.lista', $data);
    }

    public function create()
    {   
        $eventos = Eventos::all();
        return view('eventos.create', compact('eventos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $eventos = new Eventos();
       $eventos->tipo = $request->tipo;
       $eventos->nombre = $request->nombre;
       $eventos->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $eventos->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $eventos->recurso = $archivo->getClientOriginalName();
        }
        $eventos->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $eventos->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $eventos->archivo = null;

        }
        $eventos->enlace = $request->enlace;


       $eventos->save();
       

       $notificacion = 'El evento se ha registrado correctamente';
       return redirect()->route('eventos.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evento = Eventos::findOrFail($id);
         $ruta_base = 'lecciones/'; 'eventos/';
        return view('eventos.show', compact('evento', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $eventos = Eventos::find($id);
        $data = [
            'eventos' =>$eventos,
        ];
        return view('eventos.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $eventos = Eventos::find($id);
        $eventos->nombre = $request->nombre;
        $eventos->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $eventos->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $eventos->recurso = $archivo->getClientOriginalName();
            }
            $eventos->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $eventos->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $eventos->archivo = null;
    
            }
            $eventos->enlace = $request->enlace;

        $notificacion = 'El evento se ha actualizado correctamente';
        $eventos->save();      
        return redirect()->route('eventos.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $eventos = Eventos::find($id);        
        $eventos->delete();
        $notificacion = 'El evento se ha eliminado correctamente';
        return redirect()->route('eventos.lista')->with(compact('notificacion'));
    }
}
