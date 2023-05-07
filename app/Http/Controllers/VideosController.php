<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videos;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
class VideosController extends Controller
{
    public function index()
    {   
        $videos = DB::table('videos')->orderByDesc('id')->paginate(8);
        $vid = Videos::withCount('likes')->get();
        return view('videos.index', compact('videos','vid'));
    }

    public function lista(Request $request)
    {   
        $busqueda = $request->busqueda;
        $videos = Videos::where('nombre','LIKE','%'.$busqueda.'%')
        ->orderBy('id','desc')
        ->paginate(6);
        $vid = Videos::withCount('likes')->get();
        $data = [
        'videos' =>$videos,
        'busqueda' =>$busqueda,
        'likes' => $vid->pluck('likes_count', 'id'),
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
       return redirect()->route('videos.lista')->with(compact('notificacion'));

    }


    public function like(Request $request){
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'video_'.$request->id;
        $cookie_value = 'like';
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === 'like') {
            return redirect()->route('videos.index')->with('error', 'Ya has dado like anteriormente');
        } elseif ($cookie_exists && $cookie_exists === 'dislike') {
            return redirect()->route('videos.index')->with('error', 'Ya has dado dislike anteriormente');
        }
    
        // Aquí se agrega la lógica para registrar el like
        $like = new Like();
        $like->video_id = $request->id;
        $like->save();
    
        // Guardar la información en la cookie
        return redirect()->route('videos.index')
            ->withCookie(cookie($cookie_name, $cookie_value, null))
            ->with('success', 'Has dado '.$cookie_value);
    }

    public function dislike(Request $request)
    {
        // Obtener el ID de la lección y la acción (like o dislike) de la cookie
        $cookie_name = 'video_'.$request->id;
        $cookie_value = 'dislike'; // asignar siempre el valor 'dislike' para este método
        $cookie_exists = $request->cookie($cookie_name);
    
        // Verificar si la cookie existe y la acción ya fue realizada
        if ($cookie_exists && $cookie_exists === $cookie_value) {
            return redirect()->route('videos.index')->with('error', 'Ya has realizado esta acción anteriormente');
        }
    
        // Buscar el like correspondiente
        $like = Like::where('video_id', $request->id)->first();
    
        // Si se encontró el like, eliminarlo
        if ($like) {
            $like->delete();
    
            // Guardar la información en la cookie
            return redirect()->route('videos.index')
                ->withCookie(cookie($cookie_name, $cookie_value, 0))
                ->with('success', 'Has dado '.$cookie_value);
        }
    
        // Si no se encontró el like, mostrar un mensaje de error
        return redirect()->route('videos.index')->with('error', 'No se encontró el like correspondiente');
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

        $notificacion = 'El video se ha actualizado correctamente';
        $videos->save();      
        return redirect()->route('videos.lista')->with(compact('notificacion'));
    }

    public function destroy(string $id)
    {
        $videos = Videos::find($id);        
        $videos->delete();
        $notificacion = 'El video se ha eliminado correctamente';
        return redirect()->route('videos.lista')->with(compact('notificacion'));
    }
}
