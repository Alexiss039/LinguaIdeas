<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class VideosController extends Controller
{
    public function index()
    {   
        $videos = DB::table('videos')->paginate(8);
        return view('videos.index', compact('videos'));
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $videos = Videos::where('nombre','LIKE','%'.$busqueda.'%')
        // ->orWhere('estado', '=', 'activo')
        //   ->latest('id')
        ->paginate(6);
        $data = [
        'videos' =>$videos,
        'busqueda' =>$busqueda,
        ];
        return view('videos.lista', $data);
    }


    public function create()
    {   
        $videos = Videos::all();
        return view('videos.create', compact('videos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

       $videos = new Videos();
       $videos->nombre = $request->nombre;
       $videos->descripcion = $request->descripcion;
       $videos->setVideoEmbedAttribute($request->input('link'));   
       $videos->save();
       

       $notificacion = 'El video se ha registrado correctamente';
       return redirect()->route('videos.index')->with(compact('notificacion'));

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
        $videos = Videos::find($id);
        $data = [
            'videos' =>$videos,
        ];
        return view('videos.edit',$data);
    }

    public function update(Request $request, string $id)
    {   
        $videos = Videos::find($id);
        $videos->nombre = $request->nombre;
        $videos->descripcion = $request->descripcion;
        $videos->setVideoEmbedAttribute($request->input('link'));

        $notificacion = 'El truco se ha actualizado correctamente';
        $videos->save();      
        return redirect()->route('videos.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $videos = Videos::find($id);        
        $videos->delete();
        $notificacion = 'El video se ha eliminado correctamente';
        return redirect()->route('videos.index')->with(compact('notificacion'));
    }
}
