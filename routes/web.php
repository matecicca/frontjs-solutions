<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RequestController;

// Controladores del panel
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\RequestAdminController;
use App\Http\Controllers\Admin\AdminAuthController;

/*
| Rutas públicas
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Blog público
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Formulario de solicitud de servicio
Route::get('/solicitar', [RequestController::class, 'create'])->name('request.create');
Route::post('/solicitar', [RequestController::class, 'store'])->name('request.store');

/*
| Rutas de autenticación del panel de administración
*/

// Esta ruta es necesaria para evitar errores del middleware "auth" (usa el guard por defecto)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Login y logout del admin (sin middleware)
Route::prefix('admin')->group(function () {
    // Formulario de login
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    // Envío de credenciales
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

/*
| Rutas del panel protegidas por autenticación
*/
Route::prefix('admin')->middleware('auth')->group(function () {
    // Dashboard principal
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD de posts del blog
    Route::resource('posts', PostAdminController::class)->except(['show']);

    // Listado y eliminación de solicitudes
    Route::get('requests', [RequestAdminController::class, 'index'])->name('admin.requests.index');
    Route::delete('requests/{id}', [RequestAdminController::class, 'destroy'])->name('admin.requests.destroy');
});
