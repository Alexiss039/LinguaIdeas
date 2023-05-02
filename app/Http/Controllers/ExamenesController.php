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
       $examenes->save();
       

       $notificacion = 'El examen se ha registrado correctamente';
       return redirect()->route('examenes.index')->with(compact('notificacion'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     $empleados = User::find($id);
    //     $servicios = Servicios::all();
    //     $servicios_ids = $empleados->servicios()->pluck('servicios.id');
    //     $data = [
    //         'empleados' =>$empleados,
    //     ];
    //     return view('empleados.edit',$data, compact('servicios', 'servicios_ids'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {   
    //     $empleado = User::find($id);
    //     $empleado->cedula = $request->cedula;
    //     $empleado->name = $request->name;
    //     $empleado->apellidos = $request->apellidos;
    //     $empleado->telefono = $request->telefono;
    //     $empleado->direccion = $request->direccion;
    //     $empleado->fecha_de_nacimiento = $request->fecha;
    //     $empleado->estado = $request->estado;
    //     $empleado->rol = $request->rol;
    //     $empleado->email = $request->email;
    //     $password = $request->input('password');

    //     if($password)
    //         $empleado['password'] = Hash::make($password);

    //     $notificacion = 'El empleado se ha actualizado correctamente';
    //     $empleado->save();
    //     $empleado->servicios()->sync($request->input('servicios'));


       
    //     return redirect()->route('empleados.index')->with(compact('notificacion'));
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $examenes = Examenes::find($id);        
        $examenes->delete();
        $notificacion = 'El examen se ha eliminado correctamente';
        return redirect()->route('examenes.index')->with(compact('notificacion'));
    }
}
