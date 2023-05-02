<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juegos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class JuegosController extends Controller
{
    public function index()
    {   
        $recursos = Juegos::where('tipo', '=', 'recurso')
                ->paginate(8);
        $multimedias = Juegos::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Juegos::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Juegos::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('juegos.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $juegos = Juegos::where('nombre','LIKE','%'.$busqueda.'%')
        // ->orWhere('estado', '=', 'activo')
        //   ->latest('id')
        ->paginate(6);
        $data = [
        'juegos' =>$juegos,
        'busqueda' =>$busqueda,
        ];
        return view('juegos.lista', $data);
    }

    public function create()
    {   
        $juegos = Juegos::all();
        return view('juegos.create', compact('juegos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $juegos = new Juegos();
       $juegos->tipo = $request->tipo;
       $juegos->nombre = $request->nombre;
       $juegos->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $juegos->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $juegos->recurso = $archivo->getClientOriginalName();
        }
        $juegos->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $juegos->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $juegos->archivo = null;

        }
        $juegos->enlace = $request->enlace;


       $juegos->save();
       

       $notificacion = 'El juego se ha registrado correctamente';
       return redirect()->route('juegos.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $juego = Juegos::findOrFail($id);
        $ruta_base = 'juegos/';
        return view('juegos.show', compact('juego', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $juegos = Juegos::find($id);
        $data = [
            'juegos' =>$juegos,
        ];
        return view('juegos.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $juegos = Juegos::find($id);
        $juegos->nombre = $request->nombre;
        $juegos->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $juegos->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $juegos->recurso = $archivo->getClientOriginalName();
            }
            $juegos->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $juegos->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $juegos->archivo = null;
    
            }
            $juegos->enlace = $request->enlace;

        $notificacion = 'El juego se ha actualizado correctamente';
        $juegos->save();      
        return redirect()->route('juegos.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $juegos = Juegos::find($id);        
        $juegos->delete();
        $notificacion = 'El juego se ha eliminado correctamente';
        return redirect()->route('juegos.index')->with(compact('notificacion'));
    }
}
