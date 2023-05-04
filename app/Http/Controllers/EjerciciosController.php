<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicios;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class EjerciciosController extends Controller
{
    public function index()
    {   
        $recursos = Ejercicios::where('tipo', '=', 'recurso')
                            ->paginate(8);
        $multimedias = Ejercicios::where('tipo', '=', 'multimedia')
                            ->paginate(8);
        $enlaces = Ejercicios::where('tipo', '=', 'enlace')
                            ->paginate(8);
        $formularios = Ejercicios::where('tipo', '=', 'formulario')
                            ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('ejercicios.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $ejercicios = Ejercicios::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'ejercicios' =>$ejercicios,
        'busqueda' =>$busqueda,
        ];
        return view('ejercicios.lista', $data);
    }

    public function create()
    {   
        $ejercicios = Ejercicios::all();
        return view('ejercicios.create', compact('ejercicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $ejercicios = new Ejercicios();
       $ejercicios->tipo = $request->tipo;
       $ejercicios->nombre = $request->nombre;
       $ejercicios->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $ejercicios->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $ejercicios->recurso = $archivo->getClientOriginalName();
        }
        $ejercicios->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $ejercicios->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $ejercicios->archivo = null;

        }
        $ejercicios->enlace = $request->enlace;


       $ejercicios->save();
       

       $notificacion = 'El ejercicio se ha registrado correctamente';
       return redirect()->route('ejercicios.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ejercicio = Ejercicios::findOrFail($id);
         $ruta_base = 'lecciones/';
        return view('ejercicios.show', compact('ejercicio', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $ejercicios = Ejercicios::find($id);
        $data = [
            'ejercicios' =>$ejercicios,
        ];
        return view('ejercicios.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $ejercicios = Ejercicios::find($id);
        $ejercicios->nombre = $request->nombre;
        $ejercicios->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $ejercicios->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $ejercicios->recurso = $archivo->getClientOriginalName();
            }
            $ejercicios->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $ejercicios->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $ejercicios->archivo = null;
    
            }
            $ejercicios->enlace = $request->enlace;

        $notificacion = 'El ejercicio se ha actualizado correctamente';
        $ejercicios->save();      
        return redirect()->route('ejercicios.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $ejercicios = Ejercicios::find($id);        
        $ejercicios->delete();
        $notificacion = 'El ejercicio se ha eliminado correctamente';
        return redirect()->route('ejercicios.lista')->with(compact('notificacion'));
    }
}
