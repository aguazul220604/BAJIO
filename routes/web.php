<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;

require __DIR__ . '/auth.php';


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/departamentos', [AdminController::class, 'admin'])->middleware(['auth', 'verified'])->name('departamentos');
Route::get('/subestaciones', [AdminController::class, 'subestaciones'])->middleware(['auth', 'verified'])->name('subestaciones');
Route::get('/horarios', [AdminController::class, 'horarios'])->middleware(['auth', 'verified'])->name('horarios');
Route::get('/novedades', [AdminController::class, 'novedades'])->middleware(['auth', 'verified'])->name('novedades');


// Departamentos
Route::post('/departamento/create', [AdminController::class, 'crear_departamento'])->name('crear.departamento');
Route::post('/departamento/{id}/editar', [AdminController::class, 'editar_departamento'])->name('editar.departamento');
Route::delete('/departamento/{id}/eliminar', [AdminController::class, 'eliminar_departamento'])->name('eliminar.departamento');

// Colaboradores
Route::get('/personal', [AdminController::class, 'personal'])->middleware(['auth', 'verified'])->name('personal');
Route::post('/colaboradores/create', [AdminController::class, 'crear_colaborador'])->name('crear.colaborador');
Route::post('/colaboradores/editar', [AdminController::class, 'editar_colaborador'])->name('editar.colaborador');
Route::delete('/colaboradores/{id}/eliminar', [AdminController::class, 'eliminar_colaborador'])->name('eliminar.colaborador');

// Perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel de consulta
Route::get('/index', [PrincipalController::class, 'index'])->name('index');
Route::get('/guardias', [PrincipalController::class, 'guardias'])->name('guardias');
Route::get('/diagramas', [PrincipalController::class, 'diagramas'])->name('diagramas');
Route::get('/directorio', [PrincipalController::class, 'directorio'])->name('directorio');
Route::get('/sitios', [PrincipalController::class, 'sitios'])->name('sitios');
Route::get('/about/{id}', [PrincipalController::class, 'about'])->name('about');
Route::get('/noticias', [PrincipalController::class, 'noticias'])->name('noticias');



// Panel administrativo
Route::get('/gestion/{id}', [AdminController::class, 'gestion'])->name('gestion');
Route::post('/admin/editar', [AdminController::class, 'editar_admin'])->name('editar.admin');

// Enlaces
Route::post('/enlaces/create', [AdminController::class, 'crear_enlace'])->name('crear.enlace');
Route::post('/enlaces/editar', [AdminController::class, 'editar_enlace'])->name('editar.enlace');
Route::delete('/enlaces/{id}/eliminar', [AdminController::class, 'eliminar_enlace'])->name('eliminar.enlace');

// Directorio
Route::post('/directorio/create', [AdminController::class, 'crear_directorio'])->name('crear.directorio');
Route::post('/directorio/editar', [AdminController::class, 'editar_directorio'])->name('editar.directorio');
Route::delete('/directorio/{id}/eliminar', [AdminController::class, 'eliminar_directorio'])->name('eliminar.directorio');

// Diagramas unifilares
Route::post('/archivo/create', [AdminController::class, 'crear_archivo'])->name('crear.archivo');
Route::delete('/archivo/eliminar/{id}', [AdminController::class, 'eliminar_archivo'])->name('archivo.eliminar');
Route::get('/archivo/{nombre}', function ($nombre) {
    return response()->file(storage_path("app/public/archivos/{$nombre}"));
})->name('archivo.abrir');

// Calendarios de guardias
Route::post('/calendario/create', [AdminController::class, 'crear_calendario'])->name('crear.calendario');
Route::delete('/calendario/eliminar/{id}', [AdminController::class, 'eliminar_calendario'])->name('calendario.eliminar');
Route::get('/calendario/{nombre}', function ($nombre) {
    return response()->file(storage_path("app/public/archivos/{$nombre}"));
})->name('calendario.abrir');

// Guardias
Route::post('/guardias/create', [AdminController::class, 'crear_guardia'])->name('crear.guardia');
Route::post('/guardias/editar', [AdminController::class, 'editar_guardia'])->name('editar.guardia');
Route::delete('/guardias/{id}/eliminar', [AdminController::class, 'eliminar_guardia'])->name('eliminar.guardia');

Route::post('/horario/editar', [AdminController::class, 'editar_horario'])->name('editar.horario');

//Novedades
Route::post('/novedades/create', [AdminController::class, 'createNovedades'])->name('noticias.createNovedades');
Route::post('/novedades/edit', [AdminController::class, 'editNovedades'])->name('noticias.editNovedades');
Route::delete('/novedades/{id}', [AdminController::class, 'deleteNovedades'])->name('noticias.deleteNovedades');
