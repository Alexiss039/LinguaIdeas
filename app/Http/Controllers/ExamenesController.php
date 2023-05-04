<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examenes;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ExamenesController extends Controller
{
    public function index()
    {   
        $examenes = DB::table('examenes')->paginate(8);
        return view('examenes.index', compact('examenes'));
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $examenes = Examenes::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $data = [
        'examenes' =>$examenes,
        'busqueda' =>$busqueda,
        ];
        return view('examenes.lista', $data);
    }

    public function create()
    {   
        $examenes = Examenes::all();
        return view('examenes.create', compact('examenes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

       $examenes = new Examenes();
       $examenes->nombre = $request->nombre;
       $examenes->descripcion = $request->descripcion;
       $examenes->enlace = $request->enlace;    
       $examenes->save();
       

       $notificacion = 'El examen se ha registrado correctamente';
       return redirect()->route('examenes.lista')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $examenes = Examenes::find($id);
        $data = [
            'examenes' =>$examenes,
        ];
        return view('examenes.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $examenes = Examenes::find($id);
        $examenes->nombre = $request->nombre;
        $examenes->descripcion = $request->descripcion;
        $examenes->enlace = $request->enlace;   

        $notificacion = 'El examen se ha actualizado correctamente';
        $examenes->save();      
        return redirect()->route('examenes.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $examenes = Examenes::find($id);        
        $examenes->delete();
        $notificacion = 'El examen se ha eliminado correctamente';
        return redirect()->route('examenes.lista')->with(compact('notificacion'));
    }
}
