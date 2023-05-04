<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historias;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class HistoriasController extends Controller
{
    public function index()
    {   
        $recursos = Historias::where('tipo', '=', 'recurso')
        ->paginate(8);
        $multimedias = Historias::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Historias::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Historias::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('historias.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $historias = Historias::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'historias' =>$historias,
        'busqueda' =>$busqueda,
        ];
        return view('historias.lista', $data);
    }

    public function create()
    {   
        $historias = Historias::all();
        return view('historias.create', compact('historias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $historias = new Historias();
       $historias->tipo = $request->tipo;
       $historias->nombre = $request->nombre;
       $historias->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $historias->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $historias->recurso = $archivo->getClientOriginalName();
        }
        $historias->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $historias->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $historias->archivo = null;

        }
        $historias->enlace = $request->enlace;


       $historias->save();
       

       $notificacion = 'La historia se ha registrado correctamente';
       return redirect()->route('historias.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $historia = Historias::findOrFail($id);
         $ruta_base = 'lecciones/'; 'historias/';
        return view('historias.show', compact('historia', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $historias = Historias::find($id);
        $data = [
            'historias' =>$historias,
        ];
        return view('historias.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $historias = Historias::find($id);
        $historias->nombre = $request->nombre;
        $historias->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $historias->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $historias->recurso = $archivo->getClientOriginalName();
            }
            $historias->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $historias->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $historias->archivo = null;
    
            }
            $historias->enlace = $request->enlace;

        $notificacion = 'La historia se ha actualizado correctamente';
        $historias->save();      
        return redirect()->route('historias.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $historias = Historias::find($id);        
        $historias->delete();
        $notificacion = 'La historia se ha eliminado correctamente';
        return redirect()->route('historias.lista')->with(compact('notificacion'));
    }
}
