<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memes;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class MemesController extends Controller
{
    public function index()
    {   
        $recursos = Memes::where('tipo', '=', 'recurso')
        ->orderBy('id','desc')
        ->paginate(8);
        $multimedias = Memes::where('tipo', '=', 'multimedia')
        ->orderBy('id','desc')
                ->paginate(8);
        $enlaces = Memes::where('tipo', '=', 'enlace')
        ->orderBy('id','desc')
                ->paginate(8);
        $formularios = Memes::where('tipo', '=', 'formulario')
        ->orderBy('id','desc')
                ->paginate(8);
        $data = [
        'recursos' =>$recursos,
        'multimedias' =>$multimedias,
        'enlaces' =>$enlaces,
        'formularios' =>$formularios,
        ];

        return view('memes.index', $data);
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $memes = Memes::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'memes' =>$memes,
        'busqueda' =>$busqueda,
        ];
        return view('memes.lista', $data);
    }

    public function create()
    {   
        $memes = Memes::all();
        return view('memes.create', compact('memes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
            'recurso' => 'mimes:pdf,doc,docx,xlsx,xls,ppt,pptx'
        ]);

       $memes = new Memes();
       $memes->tipo = $request->tipo;
       $memes->nombre = $request->nombre;
       $memes->descripcion = $request->descripcion;
       if($request->hasFile('imagen')){
        $archivo =$request->file('imagen');
        $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
        $memes->imagen = $archivo->getClientOriginalName();
        }
       if($request->hasFile('recurso')){
        $archivo =$request->file('recurso');
        $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
        $memes->recurso = $archivo->getClientOriginalName();
        }
        $memes->setVideoEmbedAttribute($request->input('link'));  
        
        // Validar que el archivo sea de tipo mp3 o mp4
        $archivo = $request->file('archivo');
        // Validar que el archivo no sea nulo
        if (!is_null($archivo)) {
        if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
            
            // Almacenar el archivo en el servidor
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $memes->archivo = $archivo->getClientOriginalName(); }
        } else {
            // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
            $memes->archivo = null;

        }
        $memes->enlace = $request->enlace;


       $memes->save();
       

       $notificacion = 'El meme se ha registrado correctamente';
       return redirect()->route('memes.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meme = Memes::findOrFail($id);
         $ruta_base = 'lecciones/'; 'memes/';
        return view('memes.show', compact('meme', 'ruta_base'));
    }

    public function edit(string $id)
    {
        $memes = Memes::find($id);
        $data = [
            'memes' =>$memes,
        ];
        return view('memes.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $memes = Memes::find($id);
        $memes->nombre = $request->nombre;
        $memes->descripcion = $request->descripcion;
        if($request->hasFile('imagen')){
            $archivo =$request->file('imagen');
            $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
            $memes->imagen = $archivo->getClientOriginalName();
            }
           if($request->hasFile('recurso')){
            $archivo =$request->file('recurso');
            $archivo->move(public_path().'/lecciones/',$archivo->getClientOriginalName());
            $memes->recurso = $archivo->getClientOriginalName();
            }
            $memes->setVideoEmbedAttribute($request->input('link'));  
            
            // Validar que el archivo sea de tipo mp3 o mp4
            $archivo = $request->file('archivo');
            // Validar que el archivo no sea nulo
            if (!is_null($archivo)) {
            if ($archivo->getClientOriginalExtension() == 'mp3' || $archivo->getClientOriginalExtension() == 'mp4') {
                
                // Almacenar el archivo en el servidor
                $archivo->move(public_path().'/recursos/',$archivo->getClientOriginalName());
                $memes->archivo = $archivo->getClientOriginalName(); }
            } else {
                // Si el archivo es nulo, asignar NULL al campo "archivo" en la base de datos
                $memes->archivo = null;
    
            }
            $memes->enlace = $request->enlace;

        $notificacion = 'El meme se ha actualizado correctamente';
        $memes->save();      
        return redirect()->route('memes.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $memes = Memes::find($id);        
        $memes->delete();
        $notificacion = 'El meme se ha eliminado correctamente';
        return redirect()->route('memes.lista')->with(compact('notificacion'));
    }
}
