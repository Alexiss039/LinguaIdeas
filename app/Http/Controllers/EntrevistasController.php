<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrevistas;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class EntrevistasController extends Controller
{
    public function index()
    {  
        $recursos = Entrevistas::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Entrevistas::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Entrevistas::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Entrevistas::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('entrevistas.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $entrevistas = Entrevistas::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'entrevistas' =>$entrevistas,
        'busqueda' =>$busqueda,
        ];
        return view('entrevistas.lista', $data);
    }

    public function create()
    {   
        $entrevistas = Entrevistas::all();
        return view('entrevistas.create', compact('entrevistas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $entrevistas = new Entrevistas();
       $entrevistas->tipo = $request->tipo;
       $entrevistas->nombre = $request->nombre;
       $entrevistas->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $entrevistas->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $entrevistas->recurso = $archivo->getClientOriginalName();
        }
        $entrevistas->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $entrevistas->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $entrevistas->archivo = null;

        }
        $entrevistas->enlace = $request->enlace;


       $entrevistas->save();
       

       $notificacion = 'La entrevista se ha registrado correctamente';
       return redirect()->route('entrevistas.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entrevista = Entrevistas::findOrFail($id);
         $ruta_base = 'lecciones/'; 'entrevistas/';
        return view('entrevistas.show', compact('entrevista', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $entrevistas = Entrevistas::find($id);
        $data = [
            'entrevistas' =>$entrevistas,
        ];
        return view('entrevistas.edit',$data);
    }
    
    public function update(Request $request, string $id)
    {   
        $entrevistas = Entrevistas::find($id);
        $entrevistas->nombre = $request->nombre;
        $entrevistas->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $entrevistas->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $entrevistas->recurso = $archivo->getClientOriginalName();
            }
            $entrevistas->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $entrevistas->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $entrevistas->archivo = null;
    
            }
            $entrevistas->enlace = $request->enlace;

        $notificacion = 'La entrevista se ha actualizado correctamente';
        $entrevistas->save();      
        return redirect()->route('entrevistas.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $entrevistas = Entrevistas::find($id);        
        $entrevistas->delete();
        $notificacion = 'La entrevista se ha eliminado correctamente';
        return redirect()->route('entrevistas.lista')->with(compact('notificacion'));
    }
}
