<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitaRequest;
use App\Mail\CitaConfirmada;
use App\Models\Citas;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SolicitudController extends Controller
{
    //
   public function store( CitaRequest $request){
  //return $request->all();

  if (! Citas::horarioDisponible($request->fecha_cita, $request->hora_cita)) {
      return back()
          ->withInput()
          ->withErrors(['hora_cita' => 'Ese turno ya fue reservado. Elige otra hora.']);
  }

  $citas=new Citas();
  $citas->name_cliente=$request->name;
  $citas->email_cliente=$request->email;
  $citas->phone_cliente=$request->phone;
  $citas->fecha_cita=$request->fecha_cita;
  $citas->hora_cita=$request->hora_cita;
  $citas->servicio_id=Servicio::desdeTexto($request->service)?->id;
  $citas->cancelacion=Str::random(64);
// 
  $citas->save();

  try {
      Mail::to($citas->email_cliente)->send(new CitaConfirmada(
          $citas->load('servicio'),
          route('citas.cancelar.enlace', ['token' => $citas->cancelacion]),
      ));
  } catch (\Throwable $e) {
      // No romper la reserva si el correo falla.
  }
  
 return back()->with('succes','cita registrada, revisa tu correo');
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
