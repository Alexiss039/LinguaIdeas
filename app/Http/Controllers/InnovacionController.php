<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Innovacion;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class InnovacionController extends Controller
{
    public function index()
    {
        $recursos = Innovacion::where('tipo', '=', 'recurso')
        ->paginate(8);
        $multimedias = Innovacion::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Innovacion::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Innovacion::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('innovacion.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $innovacion = Innovacion::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'innovacion' =>$innovacion,
        'busqueda' =>$busqueda,
        ];
        return view('innovacion.lista', $data);
    }

    public function create()
    {   
        $innovacion = Innovacion::all();
        return view('innovacion.create', compact('innovacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $innovacion = new Innovacion();
       $innovacion->tipo = $request->tipo;
       $innovacion->nombre = $request->nombre;
       $innovacion->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $innovacion->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $innovacion->recurso = $archivo->getClientOriginalName();
        }
        $innovacion->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $innovacion->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $innovacion->archivo = null;

        }
        $innovacion->enlace = $request->enlace;


       $innovacion->save();
       

       $notificacion = 'La innovacion se ha registrado correctamente';
       return redirect()->route('innovacion.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $innovacion = Innovacion::findOrFail($id);
         $ruta_base = 'lecciones/'; 'innovacion/';
        return view('innovacion.show', compact('innovacion', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $innovacion = Innovacion::find($id);
        $data = [
            'innovacion' =>$innovacion,
        ];
        return view('innovacion.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $innovacion = Innovacion::find($id);
        $innovacion->nombre = $request->nombre;
        $innovacion->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $innovacion->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $innovacion->recurso = $archivo->getClientOriginalName();
            }
            $innovacion->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $innovacion->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $innovacion->archivo = null;
    
            }
            $innovacion->enlace = $request->enlace;

        $notificacion = 'La innovacion se ha actualizado correctamente';
        $innovacion->save();      
        return redirect()->route('innovacion.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $innovacion = Innovacion::find($id);        
        $innovacion->delete();
        $notificacion = 'La innovación se ha eliminado correctamente';
        return redirect()->route('innovacion.lista')->with(compact('notificacion'));
    }
}
