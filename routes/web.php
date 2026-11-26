<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SolicitudController;
use App\Models\DatosNegocio;
use App\Models\horario_barberias;
use App\Models\Servicio;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $servicios = Servicio::orderBy('id')->get()->keyBy('nombre');
    $horarios = horario_barberias::orderBy('dias_semana')->get()->keyBy('dias_semana');
    $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    $hoy = $horarios[now()->dayOfWeek] ?? null;
    $datos = DatosNegocio::first();

    return view('index', compact('servicios', 'horarios', 'dias', 'hoy', 'datos'));
});
Route::post('index/store', [SolicitudController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('index.store');

// Wizard de reserva (3 pasos: servicio → fecha/hora → confirmación)
Route::get('/reservar', [ReservaController::class, 'index'])->name('reservar');
Route::post('/reservar', [ReservaController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('reservar.store');

// Disponibilidad de turnos: /disponibilidad?fecha=YYYY-MM-DD
Route::get('/disponibilidad', [ReservaController::class, 'disponibilidad'])
    ->middleware('throttle:60,1')
    ->name('disponibilidad');

// Cancelación por enlace (token único):
// GET muestra la confirmación, POST cancela de verdad.
// El GET ya no cambia nada: ni un prefetch ni un antivirus
// que siga enlaces del correo puede cancelar la cita.
Route::get('/cancelar-cita/{token}', [ReservaController::class, 'cancelarPorEnlace'])
    ->middleware('throttle:30,1')
    ->name('citas.cancelar.enlace');
Route::post('/cancelar-cita/{token}', [ReservaController::class, 'confirmarCancelacionPorEnlace'])
    ->middleware('throttle:30,1')
    ->name('citas.cancelar.enlace.confirmar');

// Reprogramación por enlace (token único)
Route::get('/reprogramar-cita/{token}', [ReservaController::class, 'reprogramarPorEnlace'])
    ->middleware('throttle:30,1')
    ->name('citas.reprogramar.enlace');
Route::post('/reprogramar-cita/{token}', [ReservaController::class, 'actualizarPorEnlace'])
    ->middleware('throttle:10,1')
    ->name('citas.reprogramar.update');

// Perfil: cualquier usuario autenticado y verificado.
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin: solo el barbero, con correo verificado.
// Antes era solo 'auth': cualquier cuenta registrada entraba.
Route::middleware(['auth', 'verified', 'barber'])->group(function () {
    // Panel del día del barbero
    Route::get('/dashboard', [AdminController::class, 'panel'])->name('dashboard');

    // Horarios semanales
    Route::get('/admin/horarios', [AdminController::class, 'horarios'])->name('admin.horarios');
    Route::post('/admin/horarios', [AdminController::class, 'actualizarHorarios'])->name('admin.horarios.update');

    // Días bloqueados (vacaciones)
    Route::get('/admin/vacaciones', [AdminController::class, 'vacaciones'])->name('admin.vacaciones');
    Route::post('/admin/vacaciones', [AdminController::class, 'guardarVacacion'])->name('admin.vacaciones.store');
    Route::delete('/admin/vacaciones/{vacacion}', [AdminController::class, 'eliminarVacacion'])->name('admin.vacaciones.destroy');

    // Precios y duración de los servicios
    Route::get('/admin/servicios', [AdminController::class, 'servicios'])->name('admin.servicios');
    Route::post('/admin/servicios', [AdminController::class, 'actualizarServicios'])->name('admin.servicios.update');

    // Datos del negocio (dirección que se muestra en la portada y el mapa)
    Route::get('/admin/datos', [AdminController::class, 'datos'])->name('admin.datos');
    Route::post('/admin/datos', [AdminController::class, 'actualizarDatos'])->name('admin.datos.update');

    // Acciones del barbero sobre las citas (panel del día)
    Route::post('/citas/{cita}/completar', [SolicitudController::class, 'completar'])->name('citas.completar');
    Route::post('/citas/{cita}/cancelar', [SolicitudController::class, 'cancelar'])->name('citas.cancelar');
});

require __DIR__.'/auth.php';
