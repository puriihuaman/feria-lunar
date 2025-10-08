<?php

use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SedeStandController;
use App\Http\Controllers\StandController;
use Illuminate\Support\Facades\Route;

// mostrar vista estática -> empieza desde resources/views
// view(ruta, vista)
Route::view('/', 'index')->name('index');
Route::view('sedes','sedes.index')->name('sedes');
// Route::view('sedes/sede-apupal','sedes.sede-apupal')->name('apupal');
// Route::view('sedes/sede-surco','sedes.sede-surco')->name('surco');

// get(ruta, controller)
// Route::get('ruta/ruta','controller');
// Route::post();
// Route::patch();
// Route::delete();
// Route::put();

// Route::get('/check-availability', [ReservationController::class, 'checkAvailability']);
// Route::post('/reservas', [ReservationController::class, 'store'])->name('reservas.store');

// Listado de stands
Route::get('/stands', [StandController::class, 'listView'])->name('stands.list');

// Listado de stands de una sede
Route::get('/sedes/{id}/stands', [SedeStandController::class, 'listView'])->name('sedes.stands');

Route::get('/reservas/create', [ReservaController::class, 'create'])->name('reservas.create');

Route::post('/reservas/store', [ReservaController::class, 'store'])->name('reservas.store');

Route::get('/reservas/success/{reserva}', [ReservaController::class, 'success'])->name('reservas.success');

// Route::middleware() // o el middleware que uses para admin
//     ->prefix('admin')
//     ->group(function () {
//         Route::get('/', [ReservaController::class, 'adminIndex'])->name('admin.index');
//         Route::patch('/reservas/{reserva}/status', [ReservaController::class, 'updateStatus'])->name('admin.updateStatus');
//     });

Route::get('/admin', [ReservaController::class, 'adminIndex'])->name('admin.index');
Route::patch('/admin/{reservation}/status', [ReservaController::class, 'updateStatus'])->name('admin.updateStatus');

Route::view('/terms', 'terms')->name('terms');