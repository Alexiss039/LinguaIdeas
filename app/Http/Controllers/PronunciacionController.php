<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pronunciacion;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class PronunciacionController extends Controller
{
    public function index()
    {   
        $recursos = Pronunciacion::where('tipo', '=', 'recurso')
        ->paginate(8);
        $multimedias = Pronunciacion::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Pronunciacion::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Pronunciacion::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('Pronunciacion.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $pronunciacion = Pronunciacion::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'pronunciacion' =>$pronunciacion,
        'busqueda' =>$busqueda,
        ];
        return view('pronunciacion.lista', $data);
    }


    public function create()
    {   
        $pronunciacion = Pronunciacion::all();
        return view('pronunciacion.create', compact('pronunciacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $pronunciacion = new Pronunciacion();
       $pronunciacion->tipo = $request->tipo;
       $pronunciacion->nombre = $request->nombre;
       $pronunciacion->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $pronunciacion->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $pronunciacion->recurso = $archivo->getClientOriginalName();
        }
        $pronunciacion->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $pronunciacion->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $pronunciacion->archivo = null;

        }
        $pronunciacion->enlace = $request->enlace;


       $pronunciacion->save();
       

       $notificacion = 'La pronunciacion se ha registrado correctamente';
       return redirect()->route('pronunciacion.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pronunciacion = Pronunciacion::findOrFail($id);
         $ruta_base = 'lecciones/'; 'pronunciacion/';
        return view('pronunciacion.show', compact('pronunciacion', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $pronunciacion = Pronunciacion::find($id);
        $data = [
            'pronunciacion' =>$pronunciacion,
        ];
        return view('pronunciacion.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $pronunciacion = Pronunciacion::find($id);
        $pronunciacion->nombre = $request->nombre;
        $pronunciacion->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $pronunciacion->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $pronunciacion->recurso = $archivo->getClientOriginalName();
            }
            $pronunciacion->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $pronunciacion->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $pronunciacion->archivo = null;
    
            }
            $pronunciacion->enlace = $request->enlace;

        $notificacion = 'La pronunciacion se ha actualizado correctamente';
        $pronunciacion->save();      
        return redirect()->route('pronunciacion.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $pronunciacion = Pronunciacion::find($id);        
        $pronunciacion->delete();
        $notificacion = 'La pronunciacion se ha eliminado correctamente';
        return redirect()->route('pronunciacion.lista')->with(compact('notificacion'));
    }
}
