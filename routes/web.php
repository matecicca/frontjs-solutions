<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserServiceController;

// Controladores del panel
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\RequestAdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UserAdminController;

/*
| Rutas públicas
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Blog público
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

/*
| Rutas de autenticación para usuarios comunes (guard web)
*/
// Registro
Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.submit');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
| Rutas protegidas para usuarios autenticados (guard web)
*/
Route::middleware(['auth:web'])->group(function () {
    // Formulario de solicitud de servicio (solo usuarios logueados)
    Route::get('/solicitar', [RequestController::class, 'create'])->name('request.create');
    Route::post('/solicitar', [RequestController::class, 'store'])->name('request.store');

    // Mis servicios - historial de solicitudes del usuario
    Route::get('/mis-servicios', [UserServiceController::class, 'index'])->name('user.services.index');
    Route::get('/mis-servicios/{id}', [UserServiceController::class, 'show'])->name('user.services.show');
});

/*
| Rutas de autenticación del panel de administración
*/

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
| Rutas del panel protegidas por autenticación y verificación de role admin
*/
Route::prefix('admin')->middleware(['auth:admin', 'admin'])->group(function () {
    // Dashboard principal
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD de posts del blog
    Route::resource('posts', PostAdminController::class)->except(['show']);

    // Gestión de solicitudes de servicio
    Route::get('requests', [RequestAdminController::class, 'index'])->name('admin.requests.index');
    Route::get('requests/{id}', [RequestAdminController::class, 'show'])->name('admin.requests.show');
    Route::put('requests/{id}/status', [RequestAdminController::class, 'updateStatus'])->name('admin.requests.updateStatus');
    Route::delete('requests/{id}', [RequestAdminController::class, 'destroy'])->name('admin.requests.destroy');

    // Gestión de usuarios (solo lectura)
    Route::get('users', [UserAdminController::class, 'index'])->name('admin.users.index');
    Route::get('users/{user}', [UserAdminController::class, 'show'])->name('admin.users.show');
});
