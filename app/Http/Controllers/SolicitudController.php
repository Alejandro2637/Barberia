<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitaRequest;
use App\Models\Citas;
use App\Models\User;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    //
   public function store( CitaRequest $request){
  //return $request->all();

  $citas=new Citas();
  $citas->name_cliente=$request->name;
  $citas->phone_cliente=$request->phone;
  $citas->fecha_cita=$request->fecha_cita;
  $citas->hora_cita=$request->hora_cita;
// 
  $citas->save(); 
  
 return back();
   } 
   
  public function completar(Citas $cita)
  {
    $cita->completar();
    return back()->with('succes','cita completada');
  }

  public function cancelar(Citas $cita, Request $request)
  {
    $cita->cancelar($request->motivo);
    return back()->with('succes','cita cancelada');
  }

}
