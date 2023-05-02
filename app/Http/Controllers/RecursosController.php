<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recursos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class RecursosController extends Controller
{
    public function index()
    {   
        $recursos = Recursos::where('tipo', '=', 'recurso')
        ->paginate(8);
        $multimedias = Recursos::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Recursos::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Recursos::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('Recursos.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $recursos = Recursos::where('nombre','LIKE','%'.$busqueda.'%')
        // ->orWhere('estado', '=', 'activo')
        //   ->latest('id')
        ->paginate(6);
        $data = [
        'recursos' =>$recursos,
        'busqueda' =>$busqueda,
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recurso = Recursos::findOrFail($id);
        $ruta_base = 'recursos/';
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
        return redirect()->route('recursos.index')->with(compact('notificacion'));
    }
}
