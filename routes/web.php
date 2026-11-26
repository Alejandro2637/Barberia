<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SolicitudController;
use App\Models\Servicio;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $servicios = Servicio::orderBy('id')->get()->keyBy('nombre');

    return view('index', compact('servicios'));
});
Route::post('index/store', [SolicitudController::class, 'store'])-> name('index.store');

// Wizard de reserva (3 pasos: servicio → fecha/hora → confirmación)
Route::get('/reservar', [ReservaController::class, 'index'])->name('reservar');
Route::post('/reservar', [ReservaController::class, 'store'])->name('reservar.store');

// Disponibilidad de turnos: /disponibilidad?fecha=YYYY-MM-DD
Route::get('/disponibilidad', [ReservaController::class, 'disponibilidad'])->name('disponibilidad');

// Cancelación por enlace (token único)
Route::get('/cancelar-cita/{token}', [ReservaController::class, 'cancelarPorEnlace'])->name('citas.cancelar.enlace');

// Reprogramación por enlace (token único)
Route::get('/reprogramar-cita/{token}', [ReservaController::class, 'reprogramarPorEnlace'])->name('citas.reprogramar.enlace');
Route::post('/reprogramar-cita/{token}', [ReservaController::class, 'actualizarPorEnlace'])->name('citas.reprogramar.update');
    
Route::middleware('auth')->group(function () {
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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Acciones del barbero sobre las citas (panel del día)
    Route::post('/citas/{cita}/completar', [SolicitudController::class, 'completar'])->name('citas.completar');
    Route::post('/citas/{cita}/cancelar', [SolicitudController::class, 'cancelar'])->name('citas.cancelar');
});

require __DIR__.'/auth.php';
