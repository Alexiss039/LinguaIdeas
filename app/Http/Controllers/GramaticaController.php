<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gramatica;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class GramaticaController extends Controller
{
    public function index()
    {   
        $recursos = Gramatica::where('tipo', '=', 'recurso')
        ->paginate(8);
        $multimedias = Gramatica::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Gramatica::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Gramatica::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('Gramatica.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $gramatica = Gramatica::where('nombre','LIKE','%'.$busqueda.'%')
        // ->orWhere('estado', '=', 'activo')
        //   ->latest('id')
        ->paginate(6);
        $data = [
        'gramatica' =>$gramatica,
        'busqueda' =>$busqueda,
        ];
        return view('gramatica.lista', $data);
    }

    public function create()
    {   
        $gramaticas = Gramatica::all();
        return view('gramatica.create', compact('gramaticas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $gramaticas = new Gramatica();
       $gramaticas->tipo = $request->tipo;
       $gramaticas->nombre = $request->nombre;
       $gramaticas->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $gramaticas->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $gramaticas->recurso = $archivo->getClientOriginalName();
        }
        $gramaticas->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $gramaticas->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $gramaticas->archivo = null;

        }
        $gramaticas->enlace = $request->enlace;


       $gramaticas->save();
       

       $notificacion = 'La gramatica se ha registrado correctamente';
       return redirect()->route('gramatica.lista')->with(compact('notificacion'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gramatica = Gramatica::findOrFail($id);
        $ruta_base = 'gramatica/';
        return view('gramatica.show', compact('gramatica', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $gramatica = Gramatica::find($id);
        $data = [
            'gramatica' =>$gramatica,
        ];
        return view('gramatica.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $gramatica = Gramatica::find($id);
        $gramatica->nombre = $request->nombre;
        $gramatica->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $gramatica->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $gramatica->recurso = $archivo->getClientOriginalName();
            }
            $gramatica->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $gramatica->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $gramatica->archivo = null;
    
            }
            $gramatica->enlace = $request->enlace;

        $notificacion = 'La gramatica se ha actualizado correctamente';
        $gramatica->save();      
        return redirect()->route('gramatica.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $gramaticas = Gramatica::find($id);        
        $gramaticas->delete();
        $notificacion = 'La gramatica se ha eliminado correctamente';
        return redirect()->route('gramatica.index')->with(compact('notificacion'));
    }
}
