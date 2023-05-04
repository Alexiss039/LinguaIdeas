<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trucos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class TrucosController extends Controller
{
    public function index()
    {   
        $recursos = Trucos::where('tipo', '=', 'recurso')
        ->paginate(8);
        $multimedias = Trucos::where('tipo', '=', 'multimedia')
                ->paginate(8);
        $enlaces = Trucos::where('tipo', '=', 'enlace')
                ->paginate(8);
        $formularios = Trucos::where('tipo', '=', 'formulario')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('Trucos.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $trucos = Trucos::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'trucos' =>$trucos,
        'busqueda' =>$busqueda,
        ];
        return view('trucos.lista', $data);
    }

    public function create()
    {   
        $trucos = Trucos::all();
        return view('trucos.create', compact('trucos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $trucos = new Trucos();
       $trucos->tipo = $request->tipo;
       $trucos->nombre = $request->nombre;
       $trucos->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $trucos->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $trucos->recurso = $archivo->getClientOriginalName();
        }
        $trucos->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $trucos->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $trucos->archivo = null;

        }
        $trucos->enlace = $request->enlace;


       $trucos->save();
       

       $notificacion = 'El truco se ha registrado correctamente';
       return redirect()->route('trucos.lista')->with(compact('notificacion'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $truco = Trucos::findOrFail($id);
         $ruta_base = 'lecciones/'; 'trucos/';
        return view('trucos.show', compact('truco', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $trucos = Trucos::find($id);
        $data = [
            'trucos' =>$trucos,
        ];
        return view('trucos.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $trucos = Trucos::find($id);
        $trucos->nombre = $request->nombre;
        $trucos->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $trucos->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $trucos->recurso = $archivo->getClientOriginalName();
            }
            $trucos->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $trucos->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $trucos->archivo = null;
    
            }
            $trucos->enlace = $request->enlace;

        $notificacion = 'El truco se ha actualizado correctamente';
        $trucos->save();      
        return redirect()->route('trucos.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $trucos = Trucos::find($id);        
        $trucos->delete();
        $notificacion = 'El truco se ha eliminado correctamente';
        return redirect()->route('trucos.lista')->with(compact('notificacion'));
    }
}
