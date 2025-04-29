<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware(['auth', 'role:admin,mahasiswa'])->group(function () {
    Route::post('/articles/{article}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});

/**
 *    - Middleware: `auth` dan `role:admin`
 *    - Prefix URL: `/admin`
 *    - Rute-rute terkait CRUD artikel:
 *        - GET `/articles` → `ArticleController@index` (route name: `admin.index`)
 *        - GET `/articles/create` → `ArticleController@create` (route name: `admin.create`)
 *        - POST `/articles` → `ArticleController@store` (route name: `admin.store`)
 *        - GET `/articles/{article}/edit` → `ArticleController@edit` (route name: `admin.edit`)
 *        - PUT `/articles/{article}` → `ArticleController@update` (route name: `admin.update`)
 *        - DELETE `/articles/{article}` → `ArticleController@destroy` (route name: `admin.destroy`)
 */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->name('admin.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('admin.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('admin.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('admin.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('admin.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('admin.destroy');
});
