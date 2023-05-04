<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecciones;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;



class LeccionesController extends Controller
{
    public function index()
    {   
        $recursos = Lecciones::where('tipo', '=', 'recurso')
                            ->paginate(8);
        $multimedias = Lecciones::where('tipo', '=', 'multimedia')
                            ->paginate(8);
        $enlaces = Lecciones::where('tipo', '=', 'enlace')
                            ->paginate(8);
        $formularios = Lecciones::where('tipo', '=', 'formulario')
                            ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('lecciones.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $lecciones = Lecciones::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        
        $data = [
        'lecciones' =>$lecciones,
        'busqueda' =>$busqueda,
        ];
        return view('lecciones.lista', $data);
    }
    
    public function create()
    {   
        $lecciones = Lecciones::all();
        return view('lecciones.create', compact('lecciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $lecciones = new Lecciones();
       $lecciones->tipo = $request->tipo;
       $lecciones->nombre = $request->nombre;
       $lecciones->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $lecciones->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $lecciones->recurso = $archivo->getClientOriginalName();
        }
        $lecciones->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $lecciones->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $lecciones->archivo = null;

        }
        $lecciones->enlace = $request->enlace;


       $lecciones->save();
       

       $notificacion = 'La lección se ha registrado correctamente';
       return redirect()->route('lecciones.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    { 
       $leccion = Lecciones::findOrFail($id);
        $ruta_base = 'lecciones/';
       return view('lecciones.show', compact('leccion', 'ruta_base'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lecciones = Lecciones::find($id);
        $data = [
            'lecciones' =>$lecciones,
        ];
        return view('lecciones.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $lecciones = Lecciones::find($id);
        $lecciones->nombre = $request->nombre;
        $lecciones->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $lecciones->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $lecciones->recurso = $archivo->getClientOriginalName();
            }
            $lecciones->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $lecciones->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $lecciones->archivo = null;
    
            }
            $lecciones->enlace = $request->enlace;

        $notificacion = 'La lección se ha actualizado correctamente';
        $lecciones->save();      
        return redirect()->route('lecciones.lista')->with(compact('notificacion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lecciones = Lecciones::find($id);        
        $lecciones->delete();
        $notificacion = 'La lección se ha eliminado correctamente';
        return redirect()->route('lecciones.lista')->with(compact('notificacion'));
    }

}
