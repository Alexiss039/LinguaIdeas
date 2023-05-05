<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Temas;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class TemasController extends Controller
{
    public function index()
    {   
        $recursos = Temas::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Temas::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Temas::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Temas::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('temas.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $temas = Temas::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'temas' =>$temas,
        'busqueda' =>$busqueda,
        ];
        return view('temas.lista', $data);
    }

    public function create()
    {   
        $temas = Temas::all();
        return view('temas.create', compact('temas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $temas = new Temas();
       $temas->tipo = $request->tipo;
       $temas->nombre = $request->nombre;
       $temas->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $temas->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $temas->recurso = $archivo->getClientOriginalName();
        }
        $temas->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $temas->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $temas->archivo = null;

        }
        $temas->enlace = $request->enlace;


       $temas->save();
       

       $notificacion = 'El tema se ha registrado correctamente';
       return redirect()->route('temas.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tema = Temas::findOrFail($id);
         $ruta_base = 'lecciones/'; 'temas/';
        return view('temas.show', compact('tema', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $temas = Temas::find($id);
        $data = [
            'temas' =>$temas,
        ];
        return view('temas.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $temas = Temas::find($id);
        $temas->nombre = $request->nombre;
        $temas->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $temas->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $temas->recurso = $archivo->getClientOriginalName();
            }
            $temas->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $temas->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $temas->archivo = null;
    
            }
            $temas->enlace = $request->enlace;

        $notificacion = 'El tema se ha actualizado correctamente';
        $temas->save();      
        return redirect()->route('temas.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $temas = Temas::find($id);        
        $temas->delete();
        $notificacion = 'El tema se ha eliminado correctamente';
        return redirect()->route('temas.lista')->with(compact('notificacion'));
    }
}
