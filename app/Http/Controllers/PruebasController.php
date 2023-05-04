<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pruebas;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class PruebasController extends Controller
{
    public function index()
    {   
        $recursos = Pruebas::where('tipo', '=', 'recurso')
        ->paginate(8);
        $multimedias = Pruebas::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Pruebas::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Pruebas::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('pruebas.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $pruebas = Pruebas::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'pruebas' =>$pruebas,
        'busqueda' =>$busqueda,
        ];
        return view('pruebas.lista', $data);
    }

    public function create()
    {   
        $pruebas = Pruebas::all();
        return view('pruebas.create', compact('pruebas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $pruebas = new Pruebas();
       $pruebas->tipo = $request->tipo;
       $pruebas->nombre = $request->nombre;
       $pruebas->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $pruebas->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $pruebas->recurso = $archivo->getClientOriginalName();
        }
        $pruebas->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $pruebas->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $pruebas->archivo = null;

        }
        $pruebas->enlace = $request->enlace;


       $pruebas->save();
       

       $notificacion = 'La prueba se ha registrado correctamente';
       return redirect()->route('pruebas.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prueba = Pruebas::findOrFail($id);
         $ruta_base = 'lecciones/'; 'pruebas/';
        return view('pruebas.show', compact('prueba', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $pruebas = Pruebas::find($id);
        $data = [
            'pruebas' =>$pruebas,
        ];
        return view('pruebas.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $pruebas = Pruebas::find($id);
        $pruebas->nombre = $request->nombre;
        $pruebas->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $pruebas->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $pruebas->recurso = $archivo->getClientOriginalName();
            }
            $pruebas->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $pruebas->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $pruebas->archivo = null;
    
            }
            $pruebas->enlace = $request->enlace;

        $notificacion = 'La prueba se ha actualizado correctamente';
        $pruebas->save();      
        return redirect()->route('pruebas.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $pruebas = Pruebas::find($id);        
        $pruebas->delete();
        $notificacion = 'La prueba se ha eliminado correctamente';
        return redirect()->route('pruebas.lista')->with(compact('notificacion'));
    }
}
